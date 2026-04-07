<?php

namespace OmegaUp\DAO\Base;

/** @access public */
abstract class ContestProblemChangeLog {
    /**
     * @param \OmegaUp\DAO\VO\ContestProblemChangeLog $Contest_Problem_Change_Log
     * @return int The auto-increment ID
     */
    final public static function create(
        \OmegaUp\DAO\VO\ContestProblemChangeLog $Contest_Problem_Change_Log
    ): int {
        $sql = '
            INSERT INTO
                `Contest_Problem_Change_Log` (
                    `contest_id`,
                    `problem_id`,
                    `user_id`,
                    `change_type`,
                    `timestamp`
                ) VALUES (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                );';
        $params = [
            intval($Contest_Problem_Change_Log->contest_id),
            intval($Contest_Problem_Change_Log->problem_id),
            intval($Contest_Problem_Change_Log->user_id),
            $Contest_Problem_Change_Log->change_type,
            \OmegaUp\DAO\DAO::toMySQLTimestamp(
                $Contest_Problem_Change_Log->timestamp
            ),
        ];
        \OmegaUp\MySQLConnection::getInstance()->Execute($sql, $params);
        $affectedRows = \OmegaUp\MySQLConnection::getInstance()->Affected_Rows();
        if ($affectedRows == 0) {
            throw new \OmegaUp\Exceptions\DuplicatedEntryInDatabaseException(
                'recordAlreadyExists'
            );
        }
        $Contest_Problem_Change_Log->change_id = (
            \OmegaUp\MySQLConnection::getInstance()->Insert_ID()
        );
        return intval($Contest_Problem_Change_Log->change_id);
    }

    /**
     * @return \OmegaUp\DAO\VO\ContestProblemChangeLog|null
     */
    final public static function getByPK(int $change_id): ?\OmegaUp\DAO\VO\ContestProblemChangeLog {
        $sql = '
            SELECT
                `change_id`,
                `contest_id`,
                `problem_id`,
                `user_id`,
                `change_type`,
                `timestamp`
            FROM
                `Contest_Problem_Change_Log`
            WHERE
                `change_id` = ?
            LIMIT 1;';
        /** @var array{change_id: int, contest_id: int, problem_id: int, user_id: int, change_type: string, timestamp: \OmegaUp\Timestamp}|null */
        $row = \OmegaUp\MySQLConnection::getInstance()->GetRow(
            $sql,
            [$change_id]
        );
        if (empty($row)) {
            return null;
        }
        return new \OmegaUp\DAO\VO\ContestProblemChangeLog($row);
    }
}
