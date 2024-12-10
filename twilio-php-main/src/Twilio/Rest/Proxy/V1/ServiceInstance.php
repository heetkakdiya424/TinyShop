<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Proxy
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


namespace Twilio\Rest\Proxy\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;
use Twilio\Rest\Proxy\V1\Service\PhoneNumberList;
use Twilio\Rest\Proxy\V1\Service\ShortCodeList;
use Twilio\Rest\Proxy\V1\Service\SessionList;


/**
 * @property string|null $sid
 * @property string|null $uniqueName
 * @property string|null $accountSid
 * @property string|null $chatInstanceSid
 * @property string|null $callbackUrl
 * @property int $defaultTtl
 * @property string $numberSelectionBehavior
 * @property string $geoMatchLevel
 * @property string|null $interceptCallbackUrl
 * @property string|null $outOfSessionCallbackUrl
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $url
 * @property array|null $links
 */
class ServiceInstance extends InstanceResource
{
    protected $_phoneNumbers;
    protected $_shortCodes;
    protected $_sessions;

    /**
     * Initialize the ServiceInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The Twilio-provided string that uniquely identifies the Service resource to delete.
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'chatInstanceSid' => Values::array_get($payload, 'chat_instance_sid'),
            'callbackUrl' => Values::array_get($payload, 'callback_url'),
            'defaultTtl' => Values::array_get($payload, 'default_ttl'),
            'numberSelectionBehavior' => Values::array_get($payload, 'number_selection_behavior'),
            'geoMatchLevel' => Values::array_get($payload, 'geo_match_level'),
            'interceptCallbackUrl' => Values::array_get($payload, 'intercept_callback_url'),
            'outOfSessionCallbackUrl' => Values::array_get($payload, 'out_of_session_callback_url'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
        ];

        $this->solution = ['sid' => $sid ?: $this->properties['sid'], ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return ServiceContext Context for this ServiceInstance
     */
    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext(
                $this->version,
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Delete the ServiceInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {

        return $this->proxy()->delete();
    }

    /**
     * Fetch the ServiceInstance
     *
     * @return ServiceInstance Fetched ServiceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ServiceInstance
    {

        return $this->proxy()->fetch();
    }

    /**
     * Update the ServiceInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ServiceInstance Updated ServiceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): ServiceInstance
    {

        return $this->proxy()->update($options);
    }

    /**
     * Access the phoneNumbers
     */
    protected function getPhoneNumbers(): PhoneNumberList
    {
        return $this->proxy()->phoneNumbers;
    }

    /**
     * Access the shortCodes
     */
    protected function getShortCodes(): ShortCodeList
    {
        return $this->proxy()->shortCodes;
    }

    /**
     * Access the sessions
     */
    protected function getSessions(): SessionList
    {
        return $this->proxy()->sessions;
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Proxy.V1.ServiceInstance ' . \implode(' ', $context) . ']';
    }
}
