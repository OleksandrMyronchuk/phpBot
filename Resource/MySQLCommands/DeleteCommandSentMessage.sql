DELETE FROM _SentMessage
WHERE _to_user_id=:_to_user_id AND
(_command='start' AND _step='1');