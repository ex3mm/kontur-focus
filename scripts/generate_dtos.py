#!/usr/bin/env python3
from __future__ import annotations

import json
import re
from dataclasses import dataclass, field
from pathlib import Path
from typing import Any, Dict, List, Optional, Tuple

ROOT = Path(__file__).resolve().parents[1]
SCHEMAS_DIR = ROOT / "docs" / "endpoints"
DTO_ROOT = ROOT / "src" / "DTOs" / "Response"

ENDPOINTS = {
    "req": "Req",
    "egrDetails": "EgrDetails",
    "legalAnalytics": "LegalAnalytics",
    "bankruptcyAnalytics": "BankruptcyAnalytics",
    "courtAnalytics": "CourtAnalytics",
    "financeAnalytics": "FinanceAnalytics",
    "fsspAnalytics": "FsspAnalytics",
    "linkAnalytics": "LinkAnalytics",
    "purchasesAnalytics": "PurchasesAnalytics",
}

SCALAR_MAP = {
    "string": "string",
    "integer": "int",
    "number": "float",
    "boolean": "bool",
}


@dataclass
class TypeRef:
    kind: str
    php_type: str
    array_of: Optional[str] = None
    array_doc: Optional[str] = None


@dataclass
class PropertyDef:
    name: str
    description: str
    type_ref: TypeRef
    nullable: bool = True


@dataclass
class ClassDef:
    name: str
    namespace: str
    file_path: Path
    properties: List[PropertyDef] = field(default_factory=list)
    is_root: bool = False


class DtoGenerator:
    def __init__(self, endpoint_key: str, endpoint_prefix: str, schema: Dict[str, Any]) -> None:
        self.endpoint_key = endpoint_key
        self.endpoint_prefix = endpoint_prefix
        self.schema = schema
        self.definitions = schema.get("definitions", {}) if isinstance(schema.get("definitions"), dict) else {}
        self.namespace = f"KonturFocus\\DTOs\\Response\\{endpoint_prefix}"
        self.target_dir = DTO_ROOT / endpoint_prefix
        self.class_defs: Dict[str, ClassDef] = {}
        self.inline_cache: Dict[Tuple[str, ...], str] = {}
        self.definition_cache: Dict[str, str] = {}

    def generate(self) -> None:
        self.target_dir.mkdir(parents=True, exist_ok=True)

        root_class = f"{self.endpoint_prefix}ResponseDto"

        root_schema = self.schema
        if self.schema.get("type") == "array":
            root_schema = self.schema.get("items", {})

        if not isinstance(root_schema, dict):
            raise ValueError(f"{self.endpoint_key}: root schema items must be object")

        self._ensure_class(root_schema, root_class, is_root=True, path=("response",))

        for class_name in sorted(self.class_defs.keys()):
            content = self._render_class(self.class_defs[class_name])
            (self.target_dir / f"{class_name}.php").write_text(content, encoding="utf-8")

    def _sanitize_schema_text(self, text: str) -> str:
        lines = []
        marker = '"description": "'

        for line in text.splitlines():
            idx = line.find(marker)
            if idx >= 0:
                start = idx + len(marker)
                end = line.rfind('",')
                if end < start:
                    end = line.rfind('"')
                if end > start:
                    value = line[start:end]
                    value = value.replace('\\"', '__ESCAPED_QUOTE__')
                    value = value.replace('"', '\\"')
                    value = value.replace('__ESCAPED_QUOTE__', '\\"')
                    line = line[:start] + value + line[end:]
            lines.append(line)

        return "\n".join(lines)

    @classmethod
    def load_schema(cls, path: Path) -> Dict[str, Any]:
        raw = path.read_text(encoding="utf-8")
        sanitized = cls("", "", {})._sanitize_schema_text(raw)  # type: ignore[arg-type]
        return json.loads(sanitized)

    def _resolve_ref(self, ref: str) -> Dict[str, Any]:
        if not ref.startswith("#/definitions/"):
            return {"type": "string"}

        definition_key = ref.split("/", 2)[-1]
        resolved = self.definitions.get(definition_key)
        if not isinstance(resolved, dict):
            return {"type": "string"}

        return resolved

    def _schema_types(self, schema: Dict[str, Any]) -> List[str]:
        raw_type = schema.get("type")
        if isinstance(raw_type, str):
            return [raw_type]
        if isinstance(raw_type, list):
            return [t for t in raw_type if isinstance(t, str)]
        if "properties" in schema:
            return ["object"]
        if "items" in schema:
            return ["array"]
        return ["string"]

    def _ensure_class(self, schema: Dict[str, Any], class_name: str, *, is_root: bool, path: Tuple[str, ...]) -> str:
        if class_name in self.class_defs:
            return class_name

        class_def = ClassDef(
            name=class_name,
            namespace=self.namespace,
            file_path=self.target_dir / f"{class_name}.php",
            is_root=is_root,
        )

        props = schema.get("properties", {})
        if not isinstance(props, dict):
            props = {}

        for prop_name, prop_schema in props.items():
            if not isinstance(prop_schema, dict):
                continue

            description = str(prop_schema.get("description", prop_name))
            type_ref = self._resolve_type(
                prop_schema,
                path=path + (prop_name,),
                default_name=prop_name,
            )

            class_def.properties.append(
                PropertyDef(
                    name=prop_name,
                    description=description,
                    type_ref=type_ref,
                    nullable=True,
                )
            )

        self.class_defs[class_name] = class_def
        return class_name

    def _resolve_type(self, schema: Dict[str, Any], *, path: Tuple[str, ...], default_name: str) -> TypeRef:
        if "$ref" in schema and isinstance(schema["$ref"], str):
            ref = schema["$ref"]
            if ref.startswith("#/definitions/"):
                def_key = ref.split("/", 2)[-1]
                ref_schema = self._resolve_ref(ref)
                return self._resolve_definition_type(def_key, ref_schema, path)
            return TypeRef(kind="scalar", php_type="string")

        types = self._schema_types(schema)
        non_null_types = [t for t in types if t != "null"]
        primary = non_null_types[0] if non_null_types else "string"

        if primary in SCALAR_MAP:
            return TypeRef(kind="scalar", php_type=SCALAR_MAP[primary])

        if primary == "array":
            items_schema = schema.get("items")
            if not isinstance(items_schema, dict):
                return TypeRef(kind="array", php_type="array", array_of="string", array_doc="string")

            item_type = self._resolve_type(
                items_schema,
                path=path + ("item",),
                default_name=f"{default_name}Item",
            )

            array_of = item_type.php_type if item_type.kind == "scalar" else item_type.php_type
            array_doc = item_type.php_type
            return TypeRef(kind="array", php_type="array", array_of=array_of, array_doc=array_doc)

        if primary == "object":
            class_name = self._inline_class_name(path, default_name)
            self._ensure_class(schema, class_name, is_root=False, path=path)
            return TypeRef(kind="object", php_type=class_name)

        return TypeRef(kind="scalar", php_type="string")

    def _resolve_definition_type(self, def_key: str, ref_schema: Dict[str, Any], path: Tuple[str, ...]) -> TypeRef:
        if def_key in self.definition_cache:
            name = self.definition_cache[def_key]
            # Может быть скалярным плейсхолдером.
            if name in SCALAR_MAP.values():
                return TypeRef(kind="scalar", php_type=name)
            if name == "array":
                return TypeRef(kind="array", php_type="array", array_of="string", array_doc="string")
            return TypeRef(kind="object", php_type=name)

        types = self._schema_types(ref_schema)
        non_null_types = [t for t in types if t != "null"]
        primary = non_null_types[0] if non_null_types else "string"

        if primary in SCALAR_MAP:
            scalar_type = SCALAR_MAP[primary]
            self.definition_cache[def_key] = scalar_type
            return TypeRef(kind="scalar", php_type=scalar_type)

        if primary == "array":
            self.definition_cache[def_key] = "array"
            items_schema = ref_schema.get("items")
            if isinstance(items_schema, dict):
                item_type = self._resolve_type(items_schema, path=path + (def_key, "item"), default_name=f"{def_key}Item")
                return TypeRef(kind="array", php_type="array", array_of=item_type.php_type, array_doc=item_type.php_type)
            return TypeRef(kind="array", php_type="array", array_of="string", array_doc="string")

        class_name = f"{self.endpoint_prefix}{self._pascal(def_key)}Dto"
        self.definition_cache[def_key] = class_name
        self._ensure_class(ref_schema, class_name, is_root=False, path=("definition", def_key))
        return TypeRef(kind="object", php_type=class_name)

    def _inline_class_name(self, path: Tuple[str, ...], default_name: str) -> str:
        if path in self.inline_cache:
            return self.inline_cache[path]

        parts = [self.endpoint_prefix]
        for piece in path:
            parts.append(self._pascal(piece))

        if not parts[-1].endswith("Dto"):
            parts.append("Dto")

        class_name = "".join(parts)
        class_name = class_name.replace("ItemDtoDto", "ItemDto")
        self.inline_cache[path] = class_name
        return class_name

    @staticmethod
    def _pascal(value: str) -> str:
        value = re.sub(r"[^A-Za-z0-9]+", " ", value)
        words = re.findall(r"[A-Z]?[a-z]+|[A-Z]+(?![a-z])|\d+", value)
        if not words:
            return "Value"
        return "".join(word[:1].upper() + word[1:] for word in words)

    def _render_class(self, class_def: ClassDef) -> str:
        imports: List[str] = []

        uses_array_of = any(prop.type_ref.kind == "array" for prop in class_def.properties)
        if uses_array_of:
            imports.append("use KonturFocus\\DTOs\\Attributes\\ArrayOf;")

        if class_def.is_root:
            imports.append("use KonturFocus\\DTOs\\Concerns\\HasRawResponse;")
            imports.append("use LogicException;")

        imports_block = "\n".join(sorted(set(imports)))
        if imports_block:
            imports_block += "\n\n"

        constructor_lines: List[str] = []
        constructor_param_docs: List[str] = []
        for prop in class_def.properties:
            type_hint = prop.type_ref.php_type
            if prop.nullable:
                type_hint = f"?{type_hint}"

            if prop.type_ref.kind == "array":
                array_of = prop.type_ref.array_of or "string"
                if array_of in SCALAR_MAP.values():
                    array_literal = f"'{array_of}'"
                elif re.match(r"^[A-Za-z_][A-Za-z0-9_]*$", array_of):
                    array_literal = f"{array_of}::class"
                else:
                    array_literal = "'string'"
                constructor_lines.append(f"        #[ArrayOf({array_literal})]")
                doc_type = prop.type_ref.array_doc or "mixed"
                constructor_lines.append(f"        /** @var array<{doc_type}>|null {self._escape_doc(prop.description)} */")
                constructor_param_docs.append(f" * @param array<{doc_type}>|null ${prop.name}")
            else:
                constructor_lines.append(f"        /** {self._escape_doc(prop.description)} */")

            constructor_lines.append(
                f"        public {type_hint} ${prop.name} = null,"
            )

        if class_def.is_root:
            constructor_lines.append("        /** Исходный JSON ответа Контур.Фокус. */")
            constructor_lines.append("        public ?string $raw = null,")

        constructor_doc = ""
        if constructor_param_docs:
            constructor_doc = "/**\n" + "\n".join(constructor_param_docs) + "\n */\n    "

        constructor_body = "\n".join(constructor_lines)

        with_raw_method = ""
        if class_def.is_root:
            assignments = []
            for prop in class_def.properties:
                assignments.append(f"            {prop.name}: $this->{prop.name},")
            assignments.append("            raw: $raw,")
            assignments_block = "\n".join(assignments)

            with_raw_method = f"""

    public function withRawResponse(string $raw): static
    {{
        if ($this->raw !== null) {{
            throw new LogicException('Raw response already assigned.');
        }}

        return new static(
{assignments_block}
        );
    }}
"""

        return f"""<?php

declare(strict_types=1);

namespace {class_def.namespace};

{imports_block}/**
 * DTO сгенерирован из docs/endpoints/{self.endpoint_key}/schema.json
 * @phpstan-consistent-constructor
 */
final readonly class {class_def.name}
{{
{('    use HasRawResponse;\n\n' if class_def.is_root else '')}    {constructor_doc}public function __construct(
{constructor_body}
    ) {{
    }}{with_raw_method}
}}
"""

    @staticmethod
    def _escape_doc(value: str) -> str:
        return value.replace("*/", "* /").replace("\n", " ").strip()


def cleanup_old_dto_files() -> None:
    for endpoint_prefix in ENDPOINTS.values():
        target_dir = DTO_ROOT / endpoint_prefix
        if not target_dir.exists():
            continue
        for file_path in target_dir.glob("*.php"):
            file_path.unlink()


def main() -> None:
    cleanup_old_dto_files()

    for endpoint_key, endpoint_prefix in ENDPOINTS.items():
        schema_path = SCHEMAS_DIR / endpoint_key / "schema.json"
        if not schema_path.exists():
            continue

        raw = schema_path.read_text(encoding="utf-8")
        sanitized = DtoGenerator("", "", {})._sanitize_schema_text(raw)
        schema = json.loads(sanitized)

        generator = DtoGenerator(endpoint_key, endpoint_prefix, schema)
        generator.generate()


if __name__ == "__main__":
    main()
