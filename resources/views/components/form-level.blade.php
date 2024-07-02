<label for="" {!! $attributes->merge([
    'class' => 'block text-sm font-medium text-secondary-700 dark:text-gray-400' . $class . '',
    'style' => '' . $styles . '',
]) !!}>
    {{ $slot }}
</label>
