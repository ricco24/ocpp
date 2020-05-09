<?php

namespace Kelemen\Ocpp\Message;

use stdClass;

class CallError implements Message
{
    private $messageTypeId = 4;

    private $messageId;

    private $errorCode;

    private $errorDescription;

    private $errorDetails;

    /**
     * Requested Action is not known by receiver
     */
    const ERROR_NOT_IMPLEMENTED = 'NotImplemented';

    /**
     * Requested Action is recognized but not supported by the receiver
     */
    const ERROR_NOT_SUPPORTED = 'NotSupported';

    /**
     * An internal error occurred and the receiver was not able to process the requested Action successfully
     */
    const ERROR_INTERNAL_ERROR = 'InternalError';

    /**
     * Payload for Action is incomplete
     */
    const ERROR_PROTOCOL_ERROR = 'ProtocolError';

    /**
     * During the processing of Action a security issue occurred preventing receiver from completing the Action successfully
     */
    const ERROR_SECURITY_ERROR = 'SecurityError';

    /**
     * Payload for Action is syntactically incorrect or not conform the PDU structure for Action
     */
    const ERROR_FORMATION_VIOLATION = 'FormationViolation';

    /**
     * Payload is syntactically correct but at least one field contains an invalid value
     */
    const ERROR_PROPERTY_CONSTRAINT_VIOLATION = 'PropertyConstraintViolation';

    /**
     * Payload for Action is syntactically correct but at least one of the fields violates occurence constraints
     */
    const ERROR_OCCURENCE_CONSTRAINT_VIOLATION = 'OccurenceConstraintViolation';

    /**
     * Payload for Action is syntactically correct but at least one of the fields violates data type constraints (e.g. “somestring”: 12)
     */
    const ERROR_TYPE_CONSTRAINT_VIOLATION = 'TypeConstraintViolation';

    /**
     * Any other error not covered by the previous ones
     */
    const ERROR_GENERIC_ERROR = 'GenericError';

    public function __construct(
        string $messageId,
        string $errorCode,
        string $errorDescription = '',
        stdClass $errorDetails = null
    ) {
        $this->messageId = $messageId;
        $this->errorCode = $errorCode;
        $this->errorDescription = $errorDescription;
        $this->errorDetails = $errorDetails ?? new stdClass();
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorDescription()
    {
        return $this->errorDescription;
    }
}