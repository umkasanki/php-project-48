<?php

namespace DiffCalc\Diff;

use Docopt;

function showHelp()
{
    $doc = <<<DOC
    gendiff -h
    Generate diff
    Usage:
      gendiff (-h|--help)
      gendiff (-v|--version)
      gendiff [--format <fmt>] <firstFile> <secondFile>
    Options:
      -h --help                     Show this screen
      -v --version                  Show version
      --format <fmt>                Report format [default: stylish]
    DOC;

    $args = Docopt::handle($doc);

    if ($args['--help']) {
        echo $doc;
        exit(0);
    }

    if ($args['--version']) {
        echo "gendiff version 1.0.0";
        exit(0);
    }

    if ($args['--format']) {
        $format = $args['--format'];
        echo "The value passed for --format is: {$format} \n";
    }

    return $args;
}

function isFileValid($file)
{
    if (!file_exists($file)) {
        echo "$file is not found.\n";
        return false;
    }

    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
    if ($fileExtension !== 'json') {
        echo "The first file is not a JSON file.\n";
        return false;
    }

    $fileContent = file_get_contents($file);
    if (json_decode($fileContent) === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "The first file does not contain valid JSON.";
        return false;
    }

    return true;
}

function getValue($fileContent, $key): ?string
{
    $result = false;
    if (array_key_exists($key, $fileContent)) {
        $result = $fileContent[$key];
    }
    return is_bool($result) ? var_export($result, true) : $result;
}

function gendiff($filepath1, $filepath2)
{
    if (!isFileValid($filepath1) || !isFileValid($filepath2)) {
        return false;
    }

    // Получите содержимое файлов и декодируйте его как JSON
    $file1Contents = json_decode(file_get_contents($filepath1), true);
    $file2Contents = json_decode(file_get_contents($filepath2), true);

    // Получить объединенный список ключей из обоих файлов
    $keys = array_keys(array_merge($file1Contents, $file2Contents));
    sort($keys); // Сортируем ключи

    $result = ""; // Результат

    // Сравните каждый ключ в обоих файлах
    foreach ($keys as $key) {
        $file1Value = getValue($file1Contents, $key);
        $file2Value = getValue($file2Contents, $key);

        if (!array_key_exists($key, $file1Contents)) {
            $result .= "  + $key: $file2Value\n"; // Ключ только во втором файле
        } elseif (!array_key_exists($key, $file2Contents)) {
            $result .= "  - $key: $file1Value\n"; // Ключ только в первом файле
        } elseif ($file1Value !== $file2Value) {
            // Ключ есть в обоих файлах, но значения разные
            $result .= "  - $key: $file1Value\n";
            $result .= "  + $key: $file2Value\n";
        } else {
            // Ключ есть в обоих файлах и значения совпадают
            $result .= "    $key: $file1Value\n";
        }
    }

    return "{\n$result}";
}
