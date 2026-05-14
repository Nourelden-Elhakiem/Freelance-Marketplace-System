<?php
function render_local_icon(string $name, string $class = '', string $label = ''): string
{
    static $cache = [];

    if (!array_key_exists($name, $cache)) {
        $path = __DIR__ . '/../assets/icons/' . $name . '.svg';
        $cache[$name] = is_file($path) ? file_get_contents($path) : '';
    }

    if ($cache[$name] === '') {
        return '';
    }

    $classes = trim('app-icon ' . $class);
    $attributes = 'class="' . htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') . '"';

    if ($label === '') {
        $attributes .= ' aria-hidden="true" focusable="false"';
    } else {
        $attributes .= ' role="img" aria-label="' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '"';
    }

    return preg_replace('/<svg\b([^>]*)>/', '<svg$1 ' . $attributes . '>', $cache[$name], 1) ?? '';
}
?>
