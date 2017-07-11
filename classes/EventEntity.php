<?php
class EventEntity
{
    protected $id;
    protected $distinct_id;
    protected $region;
    protected $email;
    protected $last_name;
    protected $first_name;
    protected $country_code;
    protected $city;
    protected $referring_domain;
    protected $referring_url;
    protected $responded;
    protected $sms_sent;
    protected $sms_to;
    protected $sms_message_id;
    protected $sms_status;
    protected $sms_remaining_balance;
    protected $sms_message_price;
    protected $sms_network;
    protected $sms_error_text;
    protected $sms_sent_date;
    protected $sms_last_sent;
    protected $last_seen;
    protected $created;
    protected $added;
    protected $last_modified;
    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data) {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }
        $this->distinct_id = $data['distinct_id'];
        $this->region = $data['region'];
        $this->email = $data['email'];
        $this->last_name = $data['last_name'];
        $this->first_name = $data['first_name'];
        $this->country_code = $data['country_code'];
        $this->city = $data['city'];
        $this->referring_domain = $data['referring_domain'];
        $this->referring_url = $data['referring_url'];
        $this->responsed = $data['responsed'];
        $this->sms_sent = $data['sms_sent'];
        $this->sms_to = $data['sms_to'];
        $this->sms_message_id = $data['sms_message_id'];
        $this->sms_status = $data['sms_status'];
        $this->sms_remaining_balance = $data['sms_remaining_balance'];
        $this->sms_message_price = $data['sms_message_price'];
        $this->sms_network = $data['sms_network'];
        $this->sms_error_text = $data['sms_error_text'];
        $this->sms_sent_date = $data['sms_sent_date'];
        $this->sms_last_sent = $data['sms_last_sent'];
        $this->last_seen = $data['last_seen'];
        $this->created = $data['created'];
        $this->added = $data['added'];
        $this->last_modified = $data['last_modified'];
    }
    public function getId() {
        return $this->id;
    }
    public function getDistinctID() {
        return $this->distinct_id;
    }
    public function getRegion() {
        return $this->region;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getLastName() {
        return $this->last_name;
    }
    public function getFirstName() {
        return $this->first_name;
    }
    public function getCountryCode() {
        return $this->country_code;
    }
    public function getCity() {
        return $this->city;
    }
    public function getReferringDomain() {
        return $this->referring_domain;
    }
    public function getReferringUrl() {
        return $this->referring_url;
    }
    public function getResponsed() {
        return $this->responsed;
    }
    public function getSmsSent() {
        return $this->sms_sent;
    }
    public function getSmsTo() {
        return $this->sms_to;
    }
    public function getSmsMessageId() {
        return $this->sms_message_id;
    }
    public function getSmsStatus() {
        return $this->sms_status;
    }
    public function getSmsRemainingBalance() {
        return $this->sms_remaining_balance;
    }
    public function getSmsMessagePrice() {
        return $this->sms_message_price;
    }
    public function getSmsNetwork() {
        return $this->sms_network;
    }
    public function getSmsErrorText() {
        return $this->sms_error_text;
    }
    public function getSmsSentDate() {
        return $this->sms_sent_date;
    }
    public function getSmsLastSent() {
        return $this->sms_last_sent;
    }
    public function getLastSeen() {
        return $this->last_seen;
    }
    public function getCreated() {
        return $this->created;
    }
    public function getAdded() {
        return $this->added;
    }
    public function getLastModified() {
        return $this->last_modified;
    }
}
