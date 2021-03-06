<?php
declare(strict_types=1);
namespace Arunnabraham\XmlDataImporter\Service\IO;

class DisplayExportOutputFileFormatService
{
    public function response(string $fileLocation): string
    {
        $parsedLocation = parse_url($fileLocation);
        $match = $parsedLocation['scheme'] ?? '';
        return in_array($match, ['http', 'https'], true) ? $fileLocation  : 'file://' . $fileLocation;
    }
}
