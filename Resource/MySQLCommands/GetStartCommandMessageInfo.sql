SELECT _message_id, _chat_id FROM _SentMessage
WHERE _to_user_id=:_to_user_id AND
(_command='start' AND _step='1')
UNION
SELECT _message_id, _chat_id FROM _ReceivedMessage
WHERE _from_id=:_from_id AND
(
(_command='start' AND _step='1') OR
(_command='cancel' AND _step='-2')
);