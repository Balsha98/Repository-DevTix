<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';
require_once __DIR__ . '/../data/ChatInputRules.php';

class ChatApiController extends AbsApiController
{
    public function get()
    {
        $chatMessages = $this->getAllChatMessages();

        $return['chat_messages'] = [];
        if (!isset($chatMessages['chat_message_id'])) {
            foreach ($chatMessages as $chatMessage) {
                $return['chat_messages'][] = $this->extractChatMessageData($chatMessage);
            }
        } else {
            $return['chat_messages'] = $this->extractChatMessageData($chatMessages);
        }

        $chatUsers = $this->getAllChatUsers();

        $return['chat_users'] = [];
        if (!isset($chatUsers['user_id'])) {
            foreach ($chatUsers as $chatUser) {
                $return['chat_users'][] = $this->extractChatUserData($chatUser);
            }
        } else {
            $return['chat_users'] = $this->extractChatUserData($chatUsers);
        }

        return ApiMessage::dataFetchAttempt($return);
    }

    public function post()
    {
        $data = $this->getData();

        // Guard clause: invalid inputs.
        if (!empty(Validate::validateInputs($data, ChatInputRules::RULES))) {
            return Validate::getValidationResult();
        }

        // Guard clause: request error.
        if (isset($this->insertNewChatMessage($data)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        $chatMessageID = $this->getLastInsertID();
        $chatMessage = $this->getChatMessageById($chatMessageID);
        $return['chat_message'] = [];

        // Check if it exists.
        if (!empty($chatMessage)) {
            $return['chat_message'] = $this->extractChatMessageData($chatMessage);
        }

        return ApiMessage::dataFetchAttempt($return);
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function extractChatMessageData(array $data)
    {
        return [
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'is_active' => $data['is_active'],
            'user_image' => $data['user_image'],
            'user_image_type' => $data['user_image_type'],
            'chat_message' => $data['chat_message'],
            'sent_at' => $data['sent_at']
        ];
    }

    private function getAllChatMessages()
    {
        $query = '
            SELECT * FROM chat_messages 
            JOIN users ON chat_messages.user_id = users.user_id 
            JOIN user_details ON users.user_id = user_details.user_id 
            ORDER BY chat_messages.sent_at ASC;
        ';

        return Session::getDbInstance()->executeQuery($query)->getQueryResult();
    }

    private function getChatMessageById(int $chatMessageID)
    {
        $query = '
            SELECT * FROM chat_messages 
            JOIN users ON chat_messages.user_id = users.user_id 
            JOIN user_details ON users.user_id = user_details.user_id 
            WHERE chat_messages.chat_message_id = :chat_message_id;
        ';

        return Session::getDbInstance()->executeQuery(
            $query, [':chat_message_id' => $chatMessageID]
        )->getQueryResult();
    }

    private function insertNewChatMessage(array $data)
    {
        $query = 'INSERT INTO chat_messages (user_id, chat_message) VALUES (:user_id, :chat_message);';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $data['user_id'], ':chat_message' => $data['chat_message']
        ])->getQueryResult();
    }

    private function extractChatUserData(array $data)
    {
        return [
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'is_active' => $data['is_active'],
            'user_image' => $data['user_image'],
            'user_image_type' => $data['user_image_type']
        ];
    }

    private function getAllChatUsers()
    {
        $query = '
            SELECT * FROM users 
            JOIN user_details ON users.user_id = user_details.user_id 
            ORDER BY users.role_id ASC, users.last_name ASC;
        ';

        return Session::getDbInstance()->executeQuery($query)->getQueryResult();
    }

    private function getLastInsertID()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT MAX(chat_message_id) AS id FROM chat_messages;',
        )->getQueryResult()['id'];
    }
}
