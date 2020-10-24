<?php

namespace Common\Menu\Model\Menu\Item\Type\Config;

use Magento\Framework\Config\SchemaLocatorInterface;
use Magento\Framework\Module\Dir;

class SchemaLocator implements SchemaLocatorInterface
{
    /**
     * Path to corresponding XSD file with validation rules for merged config
     *
     * @var string
     */
    protected $schema = null;

    /**
     * Path to corresponding XSD file with validation rules for separate config files
     *
     * @var string
     */
    protected $perFileSchema = null;

    /**
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     */
    public function __construct(\Magento\Framework\Module\Dir\Reader $moduleReader)
    {
        $etcDir = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'Common_Menu');
        $this->perFileSchema = $etcDir . '/menu_item_types.xsd';
        $this->schema = $etcDir . '/menu_item_types_merged.xsd';
    }

    /**
     * @return string|null
     */
    public function getPerFileSchema()
    {
        return $this->perFileSchema;
    }

    /**
     * @return string|null
     */
    public function getSchema()
    {
        return $this->schema;
    }
}
