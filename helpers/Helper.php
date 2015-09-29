<?php

namespace yii\gii\plus\helpers;

use PDO,
    Yii;


class Helper
{

    public static function getTableNames()
    {
        $db = Yii::$app->getDb();
        if (!$db->getIsActive()) {
            $db->open();
        }
        switch ($db->pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'mysql':
                return $db->createCommand('SHOW TABLES;')->queryColumn();
            case 'pgsql':
                return $db->createCommand('SELECT table_name FROM information_schema.tables WHERE table_schema = :table_schema;', [':table_schema' => 'public'])->queryColumn();
            default:
                return [];
        }
    }

    public static function getBaseModelClasses()
    {
        return [];
    }

    public static function getModelClasses()
    {
        return [];
    }

    public static function getBaseSearchModelClasses()
    {
        return [];
    }

    public static function sortUse(array &$use)
    {
        usort($use, function ($use1, $use2) {
            return strcasecmp(preg_replace('~^.+[\\\\ ]([^\\\\ ]+)$~', '$1', $use1), preg_replace('~^.+[\\\\ ]([^\\\\ ]+)$~', '$1', $use2));
        });
    }
}
