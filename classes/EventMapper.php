<?php
class EventMapper extends Mapper
{
    /**
     * Get all Events
     */
    public function getEvents() {
        $sql = "SELECT * from mixpanel_event";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new EventEntity($row);
        }
        return $results;
    }

    /**
     * Get one Event by Distinct ID
     */
    public function getEventById($distinct_id) {
        $sql = "SELECT * from mixpanel_event where distinct_id = :distinct_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["distinct_id" => $distinct_id]);
        if($result) {
            return $stmt->fetch();
        }
    }

    /**
     * Get one Event by Distinct ID
     */
    public function getEventStatus($distinct_id) {
        $sql = "SELECT true as status from mixpanel_event where distinct_id = :distinct_id limit 1";
        //$sql = "SELECT if(distinct_id=:distinct_id, true, false) from mixpanel_event where 1"; 
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["distinct_id" => $distinct_id]);
        if($result) {
            return $stmt->fetch();
        }
    }

    /**
     * Get SMS status by Event's Distinct ID
     */
    public function getSmsSentStatus($distinct_id) {
        $sql = "SELECT true as status from mixpanel_event where distinct_id = :distinct_id and sms_sent=1";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["distinct_id" => $distinct_id]);
        if($result) {
            return $stmt->fetch();
        }
    }

    /**
     * Add new Event
     */
    public function addNew(EventEntity $event) {
        $sql = "INSERT INTO mixpanel_event 
            (distinct_id, region, email, last_name, first_name, country_code, city, referring_domain, referring_url, responsed, sms_sent, sms_to, sms_message_id, sms_status, sms_remaining_balance, sms_message_price, sms_network, sms_error_text, sms_sent_date, sms_last_sent, last_seen, created, added, last_modified) VALUES
            (:distinct_id, :region, :email, :last_name, :first_name, :country_code, :city, :referring_domain, :referring_url, :responsed, :sms_sent, :sms_to, :sms_message_id, :sms_status, :sms_remaining_balance, :sms_message_price, :sms_network, :sms_error_text, :sms_sent_date, :sms_last_sent, :last_seen, :created, :added, :last_modified)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "distinct_id" => $event->getDistinctID(),
            "region" => $event->getRegion(),
            "email" => $event->getEmail(),
            "last_name" => $event->getLastName(),
            "first_name" => $event->getFirstName(),
            "country_code" => $event->getCountryCode(),
            "city" => $event->getCity(),
            "referring_domain" => $event->getReferringDomain(),
            "referring_url" => $event->getReferringUrl(),
            "responsed" => $event->getResponsed(),
            "sms_sent" => $event->getSmsSent(),
            "sms_to" => $event->getSmsTo(),
            "sms_message_id" => $event->getSmsMessageId(),
            "sms_status" => $event->getSmsStatus(),
            "sms_remaining_balance" => $event->getSmsRemainingBalance(),
            "sms_message_price" => $event->getSmsMessagePrice(),
            "sms_network" => $event->getSmsNetwork(),
            "sms_error_text" => $event->getSmsErrorText(),
            "sms_sent_date" => $event->getSmsSentDate(),
            "sms_last_sent" => $event->getSmsLastSent(),
            "last_seen" => $event->getLastSeen(),
            "created" => $event->getCreated(),
            "added" => $event->getAdded(),
            "last_modified" => $event->getLastModified(),
        ]);
        if(!$result) {
            throw new Exception("Could not add new Mixpanel Event");
        }
    }

    /**
     * Add new SMS 
     */
    public function addNewSMS(EventEntity $event, $distinct_id) {
        $sql = "update mixpanel_event
		SET
		sms_sent = :sms_sent,
		sms_to = :sms_to,
		sms_message_id = :sms_message_id,
		sms_status = :sms_status,
		sms_remaining_balance = :sms_remaining_balance,
		sms_message_price = :sms_message_price,
		sms_network = :sms_network,
		sms_error_text = :sms_error_text,
		sms_sent_date = :sms_sent_date,
		sms_last_sent = :sms_last_sent
		WHERE
		distinct_id = :distinct_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "sms_sent" => $event->getSmsSent(),
            "sms_to" => $event->getSmsTo(),
            "sms_message_id" => $event->getSmsMessageId(),
            "sms_status" => $event->getSmsStatus(),
            "sms_remaining_balance" => $event->getSmsRemainingBalance(),
            "sms_message_price" => $event->getSmsMessagePrice(),
            "sms_network" => $event->getSmsNetwork(),
            "sms_error_text" => $event->getSmsErrorText(),
            "sms_sent_date" => $event->getSmsSentDate(),
            "sms_last_sent" => $event->getSmsLastSent(),
            "distinct_id" => $distinct_id,
        ]);
        if(!$result) {
            throw new Exception("Could not add SMS record");
        }
    }
}
