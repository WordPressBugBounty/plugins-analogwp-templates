<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3d7943d6239a194f1b10d05117234d3b
{
    public static $classMap = array (
        'Analog\\Dependencies\\enshrined\\svgSanitize\\ElementReference\\Resolver' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/ElementReference/Resolver.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\ElementReference\\Subject' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/ElementReference/Subject.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\ElementReference\\Usage' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/ElementReference/Usage.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\Exceptions\\NestingException' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/Exceptions/NestingException.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\Helper' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/Helper.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\Sanitizer' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/Sanitizer.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\data\\AllowedAttributes' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/AllowedAttributes.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\data\\AllowedTags' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/AllowedTags.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\data\\AttributeInterface' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/AttributeInterface.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\data\\TagInterface' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/TagInterface.php',
        'Analog\\Dependencies\\enshrined\\svgSanitize\\data\\XPath' => __DIR__ . '/..' . '/enshrined/svg-sanitize/src/data/XPath.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit3d7943d6239a194f1b10d05117234d3b::$classMap;

        }, null, ClassLoader::class);
    }
}
