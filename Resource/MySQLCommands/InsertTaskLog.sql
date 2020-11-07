INSERT INTO _AETaskLog
(_id, _keyToAETask, _time_of_last_execution)
VALUES
(_id, :_keyToAETask, :_time_of_last_execution)
ON DUPLICATE KEY UPDATE
_time_of_last_execution = :_time_of_last_execution2;