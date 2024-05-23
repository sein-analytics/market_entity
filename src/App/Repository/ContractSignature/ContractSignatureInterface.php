<?php

namespace App\Repository\ContractSignature;

interface ContractSignatureInterface
{
    const CS_QRY_SENDER_ID_KEY = 'sender_id';

    const CS_QRY_RECEIVER_ID_KEY = 'receiver_id';

    const CS_QRY_CONTRACT_STATUS_ID_KEY = 'contract_status_id';

    const CS_QRY_SENDER_SIGNATURE_KEY = 'sender_signature';

    const CS_QRY_RECEIVER_SIGNATURE_KEY = 'receiver_signature';

    const CS_QRY_SIGNATURE_ID_KEY = 'signature_id';

    const CS_QRY_PUBLIC_ID_KEY = 'public_id';

    const CS_SENDER_ID_KEY = 'senderId';

    const CS_RECEIVER_ID_KEY = 'receiverId';

    const CS_CONTRACT_STATUS_ID_KEY = 'contractStatusId';

    const CS_SENDER_SIGNATURE_KEY = 'senderSignature';

    const CS_RECEIVER_SIGNATURE_KEY = 'receiverSignature';

    const CS_SIGNATURE_ID_KEY = 'signatureId';

    const CS_PUBLIC_ID_KEY = 'publicId';

    const CS_CONTRACT_SIGNATURE_ID_KEY = 'contractSignatureId';

    const CONTRACT_STATUS_SIGN_PENDING = 'signature_pending';

    const CONTRACT_STATUS_SENDER_SIGNED = 'sender_signed';

    const CONTRACT_STATUS_RECEIVER_SIGNED = 'receiver_signed';

    const CONTRACT_STATUS_EXECUTED = 'executed';

    const CONTRACT_STATUS_SIGN_PENDING_ID = 1;

    const CONTRACT_STATUS_SENDER_SIGNED_ID = 2;

    const CONTRACT_STATUS_RECEIVER_SIGNED_ID = 3;

    const CONTRACT_STATUS_EXECUTED_ID = 4; 

    const CONTRACT_STATUS_IDS_MAP = [
        self::CONTRACT_STATUS_SIGN_PENDING =>
            self::CONTRACT_STATUS_SIGN_PENDING_ID,
        self::CONTRACT_STATUS_SENDER_SIGNED =>
            self::CONTRACT_STATUS_SENDER_SIGNED_ID,
        self::CONTRACT_STATUS_RECEIVER_SIGNED =>
            self::CONTRACT_STATUS_RECEIVER_SIGNED_ID,
        self::CONTRACT_STATUS_EXECUTED =>
            self::CONTRACT_STATUS_EXECUTED_ID
    ];

    const GET_SENDER_SIGNATURE_KEY = 'getSenderSignature';

    const GET_RECEIVER_SIGNATURE_KEY = 'getReceiverSignature';

    const SIGNATURE_STATUS_GETTER_MAP = [
        self::CONTRACT_STATUS_SIGN_PENDING => 
            self::GET_SENDER_SIGNATURE_KEY,
        self::CONTRACT_STATUS_SENDER_SIGNED =>
            self::GET_RECEIVER_SIGNATURE_KEY
    ];

    const CONTRACT_SIGNATURE_STATUS_UPDATE_MAP = [
        self::CONTRACT_STATUS_SIGN_PENDING =>
            self::CONTRACT_STATUS_SENDER_SIGNED,
        self::CONTRACT_STATUS_SENDER_SIGNED =>
            self::CONTRACT_STATUS_EXECUTED
    ];
    
}