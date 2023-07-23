<?php
namespace App\Libraries;

class AgoraTokenGenerator
{
    const AttendeePrivileges = array(
        AccessToken::Privileges["kJoinChannel"] => 0,
        AccessToken::Privileges["kPublishAudioStream"] => 0,
        AccessToken::Privileges["kPublishVideoStream"] => 0,
        AccessToken::Privileges["kPublishDataStream"] => 0
    );


    const PublisherPrivileges = array(
        AccessToken::Privileges["kJoinChannel"] => 0,
        AccessToken::Privileges["kPublishAudioStream"] => 0,
        AccessToken::Privileges["kPublishVideoStream"] => 0,
        AccessToken::Privileges["kPublishDataStream"] => 0,
        AccessToken::Privileges["kPublishAudioCdn"] => 0,
        AccessToken::Privileges["kPublishVideoCdn"] => 0,
        AccessToken::Privileges["kInvitePublishAudioStream"] => 0,
        AccessToken::Privileges["kInvitePublishVideoStream"] => 0,
        AccessToken::Privileges["kInvitePublishDataStream"] => 0
    );

    const SubscriberPrivileges = array(
        AccessToken::Privileges["kJoinChannel"] => 0,
        AccessToken::Privileges["kRequestPublishAudioStream"] => 0,
        AccessToken::Privileges["kRequestPublishVideoStream"] => 0,
        AccessToken::Privileges["kRequestPublishDataStream"] => 0
    );

    const AdminPrivileges = array(
        AccessToken::Privileges["kJoinChannel"] => 0,
        AccessToken::Privileges["kPublishAudioStream"] => 0,
        AccessToken::Privileges["kPublishVideoStream"] => 0,
        AccessToken::Privileges["kPublishDataStream"] => 0,
        AccessToken::Privileges["kAdministrateChannel"] => 0
    );
    const Role = array(
        "kRoleAttendee" => 0,  // for communication
        "kRolePublisher" => 1, // for live broadcast
        "kRoleSubscriber" => 2,  // for live broadcast
        "kRoleAdmin" => 101
    );

    const RolePrivileges = array(
        self::Role["kRoleAttendee"] => self::AttendeePrivileges,
        self::Role["kRolePublisher"] => self::PublisherPrivileges,
        self::Role["kRoleSubscriber"] => self::SubscriberPrivileges,
        self::Role["kRoleAdmin"] => self::AdminPrivileges
    );

    public $token;

    /**
     * AgoraTokenGenerator constructor.
     * @param $appID
     * @param $appCertificate
     * @param $channelName
     * @param $uid
     * @throws \Exception
     */
    public function __construct($appID, $appCertificate, $channelName, $uid){
        $this->token = new AccessToken();
        $this->token->appID = $appID;
        $this->token->appCertificate = $appCertificate;
        $this->token->channelName = $channelName;
        $this->token->setUid($uid);
    }

    /**
     * @param $token
     * @param $appCertificate
     * @param $channel
     * @param $uid
     * @throws \Exception
     */
    public function initWithToken($token, $appCertificate, $channel, $uid){
        $this->token = AccessToken::initWithToken($token, $appCertificate, $channel, $uid);
    }

    /**
     * @param $role
     */
    public function initPrivilege($role){
        $p = self::RolePrivileges[$role];
        foreach($p as $key => $value){
            $this->setPrivilege($key, $value);
        }
    }

    /**
     * @param $privilege
     * @param $expireTimestamp
     */
    public function setPrivilege($privilege, $expireTimestamp){
        $this->token->addPrivilege($privilege, $expireTimestamp);
    }

    /**
     * @param $privilege
     */
    public function removePrivilege($privilege){
        unset($this->token->message->privileges[$privilege]);
    }

    /**
     * @return string
     */
    public function buildToken(){
        return $this->token->build();
    }
}

class AccessToken
{

    const Privileges = array(
        "kJoinChannel" => 1,
        "kPublishAudioStream" => 2,
        "kPublishVideoStream" => 3,
        "kPublishDataStream" => 4,
        "kPublishAudioCdn" => 5,
        "kPublishVideoCdn" => 6,
        "kRequestPublishAudioStream" => 7,
        "kRequestPublishVideoStream" => 8,
        "kRequestPublishDataStream" => 9,
        "kInvitePublishAudioStream" => 10,
        "kInvitePublishVideoStream" => 11,
        "kInvitePublishDataStream" => 12,
        "kAdministrateChannel" => 101
    );

    public $appID, $appCertificate, $channelName, $uid;

    public $message;

    /**
     * AccessToken constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->message = new Message();
    }

    /**
     * @param $uid
     */
    public function setUid($uid)
    {
        if ($uid === 0) {
            $this->uid = "";
        } else {
            $this->uid = $uid . '';
        }
    }

    /**
     * @param $name
     * @param $str
     * @return bool
     */
    public function is_nonempty_string($name, $str)
    {
        if (is_string($str) && $str !== "") {
            return true;
        }
        echo $name . " check failed, should be a non-empty string";
        return false;
    }

    /**
     * @param $appID
     * @param $appCertificate
     * @param $channelName
     * @param $uid
     * @return AccessToken|null
     * @throws \Exception
     */
    public static function init($appID, $appCertificate, $channelName, $uid)
    {
        $accessToken = new AccessToken();
        if (!$accessToken->is_nonempty_string("appID", $appID) ||
            !$accessToken->is_nonempty_string("appCertificate", $appCertificate) ||
            !$accessToken->is_nonempty_string("channelName", $channelName)) {
            return null;
        }
        $accessToken->appID = $appID;
        $accessToken->appCertificate = $appCertificate;
        $accessToken->channelName = $channelName;
        $accessToken->setUid($uid);
        $accessToken->message = new Message();
        return $accessToken;
    }

    /**
     * @param $token
     * @param $appCertificate
     * @param $channel
     * @param $uid
     * @return AccessToken|null
     * @throws \Exception
     */
    public static function initWithToken($token, $appCertificate, $channel, $uid)
    {
        $accessToken = new AccessToken();
        if (!$accessToken->extract($token, $appCertificate, $channel, $uid)) {
            return null;
        }
        return $accessToken;
    }

    /**
     * @param $key
     * @param $expireTimestamp
     * @return $this
     */
    public function addPrivilege($key, $expireTimestamp)
    {
        $this->message->privileges[$key] = $expireTimestamp;
        return $this;
    }

    /**
     * @param $token
     * @param $appCertificate
     * @param $channelName
     * @param $uid
     * @return bool
     * @throws \Exception
     */
    protected function extract($token, $appCertificate, $channelName, $uid)
    {
        $ver_len = 3;
        $appid_len = 32;
        $version = substr($token, 0, $ver_len);
        if ($version !== "006") {
            echo 'invalid version ' . $version;
            return false;
        }
        if (!$this->is_nonempty_string("token", $token) ||
            !$this->is_nonempty_string("appCertificate", $appCertificate) ||
            !$this->is_nonempty_string("channelName", $channelName)) {
            return false;
        }
        $appid = substr($token, $ver_len, $appid_len);
        $content = (base64_decode(substr($token, $ver_len + $appid_len, strlen($token) - ($ver_len + $appid_len))));
        $pos = 0;
        $len = unpack("v", $content . substr($pos, 2))[1];
        $pos += 2;
        $sig = substr($content, $pos, $len);
        $pos += $len;
        $crc_channel = unpack("V", substr($content, $pos, 4))[1];
        $pos += 4;
        $crc_uid = unpack("V", substr($content, $pos, 4))[1];
        $pos += 4;
        $msgLen = unpack("v", substr($content, $pos, 2))[1];
        $pos += 2;
        $msg = substr($content, $pos, $msgLen);
        $this->appID = $appid;
        $message = new Message();
        $message->unpackContent($msg);
        $this->message = $message;
        //non reversable values
        $this->appCertificate = $appCertificate;
        $this->channelName = $channelName;
        $this->setUid($uid);
        return true;
    }

    /**
     * @return string
     */
    public function build()
    {
        $msg = $this->message->packContent();
        $val = array_merge(unpack("C*", $this->appID), unpack("C*", $this->channelName), unpack("C*", $this->uid), $msg);

        $sig = hash_hmac('sha256', implode(array_map("chr", $val)), $this->appCertificate, true);
        $crc_channel_name = crc32($this->channelName) & 0xffffffff;
        $crc_uid = crc32($this->uid) & 0xffffffff;
        $content = array_merge(unpack("C*", $this->packString($sig)), unpack("C*", pack("V", $crc_channel_name)), unpack("C*", pack("V", $crc_uid)), unpack("C*", pack("v", count($msg))), $msg);
        $version = "006";
        $ret = $version . $this->appID . base64_encode(implode(array_map("chr", $content)));
        return $ret;
    }

    /**
     * @param $value
     * @return string
     */
    public function packString($value)
    {
        return pack("v", strlen($value)) . $value;
    }
}

class Message
{
    public $salt;

    public $ts;

    public $privileges;

    /**
     * Message constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->salt = rand(0, 100000);
        $date = new \DateTime("now", new \DateTimeZone('UTC'));
        $this->ts = $date->getTimestamp() + 168 * 3600; // 7天时间
        $this->privileges = array();
    }

    /**
     * @return array
     */
    public function packContent()
    {
        $buffer = unpack("C*", pack("V", $this->salt));
        $buffer = array_merge($buffer, unpack("C*", pack("V", $this->ts)));
        $buffer = array_merge($buffer, unpack("C*", pack("v", sizeof($this->privileges))));
        foreach ($this->privileges as $key => $value) {
            $buffer = array_merge($buffer, unpack("C*", pack("v", $key)));
            $buffer = array_merge($buffer, unpack("C*", pack("V", $value)));
        }
        return $buffer;
    }

    /**
     * @param $msg
     */
    public function unpackContent($msg)
    {
        $pos = 0;
        $salt = unpack("V", substr($msg, $pos, 4))[1];
        $pos += 4;
        $ts = unpack("V", substr($msg, $pos, 4))[1];
        $pos += 4;
        $size = unpack("v", substr($msg, $pos, 2))[1];
        $pos += 2;
        $privileges = array();
        for ($i = 0; $i < $size; $i++) {
            $key = unpack("v", substr($msg, $pos, 2));
            $pos += 2;
            $value = unpack("V", substr($msg, $pos, 4));
            $pos += 4;
            $privileges[$key[1]] = $value[1];
        }
        $this->salt = $salt;
        $this->ts = $ts;
        $this->privileges = $privileges;
    }
}