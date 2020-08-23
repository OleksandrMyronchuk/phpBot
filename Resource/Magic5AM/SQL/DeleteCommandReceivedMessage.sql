DELETE FROM _ReceivedMessage
WHERE _from_id=:_from_id AND
(
(_command='start' AND _step='1') OR
(_command='cancel' AND _step='-2')
)