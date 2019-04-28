<?php
namespace Bot;

class Message
{
    private $message;
    private $attachments;
    private $peer_id;
    private $random_id;
    const EMPTY_CONTEXT = '';

    /**
     * Message constructor.
     * @param $peer_id
     * @param string|null $message
     * @param array|null $attachments
     * @throws \Exception
     */
    public function __construct($peer_id, $message = null, $attachments = null)
    {
        if ($message === null && $attachments === null) {
            throw new \Exception('At least 1 argument must be not null');
        }
        $this->random_id = mt_rand();
        $this->peer_id = $peer_id;
        $this->message = $message;
        $this->attachments = $attachments;
    }

    /**
     * @param $data
     * @return Message
     * @throws \Exception
     */
    public static function buildFromArray($data)
    {
        $peer_id = isset($data['peer_id']) ? $data['peer_id'] : null;
        $message = isset($data['message']) ? $data['message'] : null;
        $attachments = isset($data['attachments']) ? $data['attachments'] : null;
        return new self($peer_id, $message, $attachments);
    }

    public function getCompiled()
    {
        $data = array(
            'random_id' => $this->random_id,
            'peer_id' => $this->peer_id,
            'message' => $this->getMessage(),
            'attachments' => $this->getAttachments()
        );
        return $data;
    }

    public function getMessage()
    {
        if ($this->message === null) {
            return self::EMPTY_CONTEXT;
        }
        return $this->message;
    }

    public function getAttachments()
    {
        if ($this->attachments === null) {
            return self::EMPTY_CONTEXT;
        }
        return implode(',', $this->attachments);
    }
}