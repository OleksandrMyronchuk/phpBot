SELECT _AETask._id, _ChatNames._chat_name, _AETask._chat_id, _AETask._action_name, _AETask._execution_time
FROM _AETask
INNER JOIN _ChatNames ON _ChatNames._chat_id=_AETask._chat_id;