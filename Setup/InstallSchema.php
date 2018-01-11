<?php
namespace Smile\Contacts\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'smile_question'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('smile_question')
        )->addColumn(
            'question_id',
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Question ID'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Customer Name'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Customer Email'
        )->addColumn(
            'phone',
            Table::TYPE_TEXT,
            16,
            ['nullable' => true, 'default' => null],
            'Phone Number'
        )->addColumn(
            'content',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Question Content'
        )->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Question Creation Time'
        )->addColumn(
            'update_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Question Modification Time'
        )->addColumn(
            'status',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Question Status'
        )->addColumn(
            'answer',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Question Answer'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('smile_question'),
                ['name', 'email', 'phone', 'content', 'answer'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['name', 'email', 'phone', 'content', 'answer'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Smile Questions Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
