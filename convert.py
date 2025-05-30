import os
import re
from pathlib import Path
from datetime import datetime

# Configuration
SOURCE_DIR = "resources/views"
TARGET_DIR = "converted_views"
LOG_FILE = "conversion_log.txt"
COMPONENT_PREFIX = "x"  # Prefix for component tags, e.g. <x-layouts.app>

# Regex patterns
extends_regex = re.compile(r"@extends\(['\"](.*?)['\"]\)")
section_regex = re.compile(r"@section\(['\"](.*?)['\"]\)(.*?)@endsection", re.DOTALL)
yield_regex = re.compile(r"@yield\(['\"](.*?)['\"]\)")
include_regex = re.compile(r"@include\(['\"](.*?)['\"]\)")
csrf_regex = re.compile(r"@csrf")
error_regex = re.compile(r"@error\(['\"](.*?)['\"]\)(.*?)@enderror", re.DOTALL)

log_entries = []
created_files = set()
referenced_partials = set()
layouts_used = set()

def log(msg):
    print(msg)
    log_entries.append(msg)

def write_log_file():
    with open(LOG_FILE, "w", encoding="utf-8") as f:
        f.write("Blade Conversion Log - " + datetime.now().strftime("%Y-%m-%d %H:%M:%S") + "\n\n")
        f.write("\n".join(log_entries))

def blade_to_component_path(blade_path):
    # Convert dot notation to slash notation, e.g. 'users.partials.list' -> 'users/partials/list'
    return blade_path.replace('.', '/')

def make_component_tag(name):
    # Wrap name with prefix, e.g. x-layouts.app
    return f"<{COMPONENT_PREFIX}-{name}>"

def make_component_close_tag(name):
    return f"</{COMPONENT_PREFIX}-{name}>"

def make_self_closing_component(name):
    return f"<{COMPONENT_PREFIX}-{name} />"

def convert_blade_file(filepath, source_base, target_base):
    rel_path = os.path.relpath(filepath, source_base)
    with open(filepath, "r", encoding="utf-8") as f:
        original_content = f.read()
    content = original_content

    layout_match = extends_regex.search(content)
    layout_component_tag = ""
    layout_path = None
    slots = {}

    # Handle layout (@extends)
    if layout_match:
        layout = layout_match.group(1)
        layouts_used.add(layout)  # Track layouts to generate full components later
        layout_path = blade_to_component_path(layout)
        layout_component_tag = make_component_tag(layout_path)
        content = extends_regex.sub("", content)
        log(f"Detected layout '{layout}' in {rel_path}")
    else:
        log(f"No layout in {rel_path}")

    # Convert @section to named slots
    sections = section_regex.findall(content)
    for name, body in sections:
        cleaned_body = body.strip()
        if name == "content":
            slots["default"] = cleaned_body
        else:
            slots[name] = f'<x-slot name="{name}">\n{cleaned_body}\n</x-slot>'
        log(f"Converted section '{name}' to slot in {rel_path}")
    content = section_regex.sub("", content)

    # Convert @yield to Blade variables (for non-layout files, sometimes yields appear)
    content = yield_regex.sub(lambda m: f"{{{{ ${m.group(1)} }}}}", content)

    # Convert @include to component tags
    def include_replacer(m):
        partial_path = blade_to_component_path(m.group(1))
        referenced_partials.add(partial_path)
        return make_self_closing_component(partial_path)
    content = include_regex.sub(include_replacer, content)

    # Convert @csrf to keep as directive (do NOT convert to component)
    content = csrf_regex.sub("@csrf", content)

    # Convert @error directives to <x-error>
    content = error_regex.sub(lambda m: f'<x-error field="{m.group(1)}">\n{m.group(2).strip()}\n</x-error>', content)

    # Combine slots and wrap in layout component tag
    output_content = ""
    if layout_component_tag:
        output_content += layout_component_tag + "\n"
        for key, value in slots.items():
            if key == "default":
                output_content += value + "\n"
            else:
                output_content += value + "\n"
        output_content += make_component_close_tag(layout_path) + "\n"
    else:
        output_content = content.strip()

    # Write transformed file
    target_path = os.path.join(target_base, rel_path)
    os.makedirs(os.path.dirname(target_path), exist_ok=True)
    with open(target_path, "w", encoding="utf-8") as f:
        f.write(output_content)
    log(f"Converted view: {rel_path}")

def create_stub_for_partial(partial_path):
    stub_path = os.path.join(TARGET_DIR, "components", partial_path + ".blade.php")
    if stub_path not in created_files:
        os.makedirs(os.path.dirname(stub_path), exist_ok=True)
        if not os.path.exists(stub_path):
            with open(stub_path, "w", encoding="utf-8") as f:
                f.write(f"<!-- Stub component for {partial_path} -->\n")
            log(f"Created stub for missing partial component: components/{partial_path}.blade.php")
        created_files.add(stub_path)

def walk_and_convert(source_dir, target_dir):
    for root, _, files in os.walk(source_dir):
        for file in files:
            if file.endswith(".blade.php"):
                full_path = os.path.join(root, file)
                convert_blade_file(full_path, source_dir, target_dir)

def convert_layout_content_to_component(content):
    # Replace @yield('content') with {{ $slot }}
    content = re.sub(r"@yield\(['\"]content['\"]\)", "{{ $slot }}", content)

    # Replace other @yield('name') with <x-slot name="name"></x-slot>
    def yield_replacer(match):
        name = match.group(1)
        if name == "content":
            return "{{ $slot }}"
        else:
            return f'<x-slot name="{name}"></x-slot>'
    content = re.sub(r"@yield\(['\"](.*?)['\"]\)", yield_replacer, content)

    # Remove @section/@show directives in layout if any (optional)
    content = re.sub(r"@section\(['\"].*?['\"]\).*?@show", "", content, flags=re.DOTALL)

    # Remove @extends (shouldn't be in layout files)
    content = re.sub(r"@extends\(['\"].*?['\"]\)", "", content)

    return content.strip()

def generate_layout_component(layout_name):
    layout_path = layout_name.replace('.', '/') + ".blade.php"
    source_path = os.path.join(SOURCE_DIR, layout_path)
    target_path = os.path.join(TARGET_DIR, "components", layout_path)

    if not os.path.exists(source_path):
        log(f"Warning: layout source file not found: {source_path}")
        return

    with open(source_path, "r", encoding="utf-8") as f:
        content = f.read()

    converted_content = convert_layout_content_to_component(content)

    os.makedirs(os.path.dirname(target_path), exist_ok=True)
    with open(target_path, "w", encoding="utf-8") as f:
        f.write(converted_content)
    log(f"Generated full layout component: components/{layout_path}")

if __name__ == "__main__":
    log("Starting Blade conversion...")
    walk_and_convert(SOURCE_DIR, TARGET_DIR)

    # Generate full layout components for all layouts used
    for layout in layouts_used:
        generate_layout_component(layout)

    # Create stubs for referenced partials missing in target
    for partial in referenced_partials:
        partial_file_path = os.path.join(TARGET_DIR, "components", partial + ".blade.php")
        if not os.path.exists(partial_file_path):
            create_stub_for_partial(partial)

    log("Conversion complete.")
    write_log_file()
    log(f"Log written to {LOG_FILE}")
