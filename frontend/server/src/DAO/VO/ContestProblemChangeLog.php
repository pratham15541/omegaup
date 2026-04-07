<?php

namespace OmegaUp\DAO\VO;

/**
 * Value Object for Contest_Problem_Change_Log table.
 *
 * @access public
 */
class ContestProblemChangeLog extends \OmegaUp\DAO\VO\VO {
    const FIELD_NAMES = [
        'change_id' => true,
        'contest_id' => true,
        'problem_id' => true,
        'user_id' => true,
        'change_type' => true,
        'timestamp' => true,
    ];

    public function __construct(?array $data = null) {
        $this->timestamp = new \OmegaUp\Timestamp(\OmegaUp\Time::get());
        if (empty($data)) {
            return;
        }
        $unknownColumns = array_diff_key(
            $data,
            self::FIELD_NAMES,
        );
        if (!empty($unknownColumns)) {
            throw new \Exception(
                'Unknown columns: ' . join(', ', array_keys($unknownColumns))
            );
        }
        if (isset($data['change_id'])) {
            $this->change_id = intval($data['change_id']);
        }
        if (isset($data['contest_id'])) {
            $this->contest_id = intval($data['contest_id']);
        }
        if (isset($data['problem_id'])) {
            $this->problem_id = intval($data['problem_id']);
        }
        if (isset($data['user_id'])) {
            $this->user_id = intval($data['user_id']);
        }
        if (isset($data['change_type'])) {
            $this->change_type = strval($data['change_type']);
        }
        if (isset($data['timestamp'])) {
            /**
             * @var \OmegaUp\Timestamp|string|int|float $data['timestamp']
             */
            $this->timestamp = (
                \OmegaUp\DAO\DAO::fromMySQLTimestamp($data['timestamp'])
            );
        }
    }

    /** @var int|null */
    public $change_id = null;

    /** @var int */
    public $contest_id = 0;

    /** @var int */
    public $problem_id = 0;

    /** @var int */
    public $user_id = 0;

    /** @var string */
    public $change_type = 'added';

    /** @var \OmegaUp\Timestamp */
    public $timestamp;
}
