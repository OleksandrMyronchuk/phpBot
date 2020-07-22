DELETE FROM _SentMessage
WHERE _to_user_id=669168176 AND
(_command='start' AND _step='1');
DELETE FROM _ReceivedMessage
WHERE _from_id=669168176 AND
(
(_command='start' AND _step='1') OR
(_command='cancel' AND _step='-2')
)