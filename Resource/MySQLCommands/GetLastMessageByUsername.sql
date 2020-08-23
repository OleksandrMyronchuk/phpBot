SELECT _command, _step
FROM _ReceivedMessage
WHERE _from_id=:_from_id
ORDER BY _id DESC
LIMIT 1