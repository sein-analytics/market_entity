<?php

namespace App\Repository\KycDocument;
use Doctrine\ORM\EntityRepository;
use App\Repository\DbalStatementInterface;
use App\Repository\Deal\DealInterface;
use App\Repository\DealContract\DealContractInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

abstract class KycDocumentAbstract extends EntityRepository
    implements DbalStatementInterface, DealInterface, DealContractInterface, KycDocumentInterface
{

    use FetchingTrait, FetchMapperTrait;

    protected static string $callKycDocumentsByUserAndIssuer = 'call KycDocumentsByUserAndIssuer(:userId, :issuerId, :communityUserId, :communityIssuerId, :assetTypeId)';

    protected static string $callFetchIssuersKycDocsAccess = 'call FetchIssuersKycDocsAccess(:issuerId)';

    protected static string $callFetchAllowedKycDocumentsIds = 'call FetchAllowedKycDocumentsIds(:issuerId, :communityIssuerId, :assetTypeId, :kycTypeId)';

    protected static string $callFetchIssuersKycDocumentsAccess = 'call FetchIssuersKycDocumentsAccess(:issuerId, :assetTypeId)';

    protected static string $callFetchKycDocumentByIssuerAndUser = 'call FetchKycDocumentByIssuerAndUser(:userId, :issuerId, :communityUserId, :communityIssuerId, :assetTypeId)';

    protected static string $callFetchUserKycDocuments = 'call FetchUserKycDocuments(:userId, :issuerId, :assetTypeId)';

    protected static string $callFetchAllowedGrantAccessIssuersIds = 'call FetchAllowedGrantAccessIssuersIds(:issuerId, :assetTypeId, :kycTypeId)';

    protected static string $callFetchKycDocumentDetails = 'call FetchKycDocumentDetails(:kycDocumentId, :userId)';

}