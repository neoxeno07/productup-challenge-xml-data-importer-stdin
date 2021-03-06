<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Formats;

use Arunnabraham\XmlDataImporter\Service\ExportDriver\DataParserAdapterInterface as ExportDriverDataParserAdapterInterface;

abstract class GenericExport implements
    ExportDriverDataParserAdapterInterface,
    ExportCoreFormatInterface
{
    protected string $exportFileLocation;
    public function returnExportOutput(string $exportLocation, $inputResource): string|null
    {
        $this->exportFileLocation = $exportLocation;
        if ($this->processData($inputResource)) {
            return $this->exportFileLocation;
        }
        return null;
    }
    public function processData($inputResource): bool
    {
        return $this->exportToFormat($inputResource);
    }

    public function exportToFormat($sourceResource): bool
    {
        try {
            $location = $this->exportFileLocation;
            if (file_exists($location)) {
                unlink($location);
            }
            $destinationResource = fopen($location, 'a');
            if (!is_resource($destinationResource)) {
                throw new \Exception('Invalid Destination Resouces');
            }
            if (!is_resource($sourceResource)) {
                throw new \Exception('Invalid Source Resouce');
            }
            rewind($sourceResource);
            $this->coreFormatAndWrite($sourceResource, $destinationResource,);
        } catch (\Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
            return false;
        }
        fclose($destinationResource);
        return true;
    }

    /**
     * @param resource $sourceResource
     * @param null|resource $destinationResource
     */
    public function coreFormatAndWrite($sourceResource, $destinationResource = null, $destinatonPath = ''): void
    {
    }
}
