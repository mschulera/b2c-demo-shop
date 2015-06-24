<?php

namespace Pyz\Zed\ProductOption\Business\Internal\DemoData;

use SprykerFeature\Zed\Installer\Business\Model\AbstractInstaller;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Writer\WriterInterface;
use Propel\Runtime\Propel;

class ProductOptionDataInstall extends AbstractInstaller
{

    /**
     * @var WriterInterface
     */
    protected $optionWriter;
    protected $productOptionWriter;

    /**
     * @param WriterInterface $optionWriter
     * @param WriterInterface $ProductOptionWriter
     */
    public function __construct(
        WriterInterface $optionWriter,
        WriterInterface $ProductOptionWriter
    ) {
        $this->optionWriter = $optionWriter;
        $this->productOptionWriter = $ProductOptionWriter;
    }

    public function install()
    {
        $this->info('This will install some demo product options and product option assignments');

        $pdo = Propel::getConnection();
        $pdo->exec("SET foreign_key_checks = 0");
        $pdo->exec("TRUNCATE spy_product_option_type_usage_exclusion");
        $pdo->exec("TRUNCATE spy_product_option_value_usage_constraint");
        $pdo->exec("TRUNCATE spy_product_option_configuration_preset_value");
        $pdo->exec("TRUNCATE spy_product_option_configuration_preset");
        $pdo->exec("TRUNCATE spy_product_option_value_usage");
        $pdo->exec("TRUNCATE spy_product_option_type_usage");
        $pdo->exec("TRUNCATE spy_product_option_value_price");
        $pdo->exec("TRUNCATE spy_product_option_value_translation");
        $pdo->exec("TRUNCATE spy_product_option_type_translation");
        $pdo->exec("TRUNCATE spy_product_option_value");
        $pdo->exec("TRUNCATE spy_product_option_type");
        $pdo->exec("SET foreign_key_checks = 1");

        $this->optionWriter->write();
        $this->productOptionWriter->write();
    }
}