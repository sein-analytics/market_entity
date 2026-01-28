<?php

namespace App\Repository;

interface MongoKeysInterface
{

    const DD_COMMENT_MONGO_ID_KEY = "_id";

    const MONGO_PROJECT_KEY = '$project';

    const MONGO_SET_KEY = '$set';

    const MONGO_SET_ON_INSERT_KEY = '$setOnInsert';

    const MONGO_MATCH_KEY = '$match';

    const MONGO_ADD_FIELDS_KEY = '$addFields';

    const MONGO_LOOKUP_KEY = '$lookup';

    const MONGO_UNWIND_KEY = '$unwind';

    const MONGO_UNWIND_PATH_KEY = "path";

    const MONGO_SORT_KEY = '$sort';

    const MONGO_SKIP_KEY = '$skip';

    const MONGO_LIMIT_KEY = '$limit';

    const MONGO_COUNT_KEY = '$count';

    const MONGO_FACET_KEY = '$facet';

    const MONGO_MAP_KEY = '$map';

    const MONGO_GROUP_KEY = '$group';

    const MONGO_MIN_KEY = '$min';

    const MONGO_IN_KEY = '$in';

    const MONGO_MERGE_OBJECTS_KEY = '$mergeObjects';

    const MONGO_LITERAL_KEY = '$literal';

    const MONGO_IF_NULL_KEY = '$ifNull';

    const MONGO_MAP_INPUT_KEY = "input";

    const MONGO_MAP_IN_KEY = "in";

    const MONGO_MAP_AS_KEY = "as";

    const MONGO_LOOKUP_FROM_KEY = "from";

    const MONGO_LOOKUP_LOCAL_FIELD_KEY = "localField";

    const MONGO_LOOKUP_FOREIGN_FIELD_KEY = "foreignField";

    const MONGO_LOOKUP_AS_KEY = "as";

    const MONGO_LOOKUP_LET_KEY = 'let';

    const MONGO_LOOKUP_PIPELINE_KEY = 'pipeline';

    const MONGO_TO_STRING_FUNCTION = '$toString';

    const MONGO_EXPR_FUNCTION = '$expr';

    const MONGO_EQ_FUNCTION = '$eq';

    const MONGO_NE_FUNCTION = '$ne';

    const MONGO_PUSH_FUNCTION = '$push';

    const MONGO_ARRAY_TO_OBJ_FUNCTION = '$arrayToObject';

    const MONGO_FILTER_FUNCTION = '$filter';

    const MONGO_COND_FUNCTION = 'cond';

    const MONGO_TO_INT_FUNCTION = '$toInt';

    const MONGO_TO_DOUBLE_FUNCTION = '$toDouble';

    const MONGO_AND_FUNCTION = '$and';

    const MONGO_SUM_FUNCTION = '$sum';

    const MONGO_ARRAY_ELEM_AT_FUNCTION = '$arrayElemAt';

    const MONGO_GROUP_COUNT_KEY = "count";

    const MONGO_OPTIONS_RETURN_DOCUMENT_KEY = "returnDocument";

    const MONGO_UNIQUE_ID_KEY = '$_id';

    const MONGO_BASE_UPDATE_STRUCTURE = [
        self::MONGO_SET_KEY => []
    ];

    const MONGO_GT_OPERATOR = '$gt';

    const MONGO_LT_OPERATOR = '$lt';

    const MONGO_GTE_OPERATOR = '$gte';

    const MONGO_REMOVE_FLAG = '$$REMOVE';

    const MONGO_CREATED_AT_KEY = 'createdAt';

    const MONGO_UPDATED_AT_KEY = 'updatedAt';

}