<?php

namespace App\Core\Http\Request;

use App\Core\Http\Message\Message;

class Request extends Message
{
    use RequestWithMethod;
    use RequestWithPath;
    use RequestWithQuery;
    use RequestWithUriParameters;
    use RequestWithValidatedData;
    use RequestWithAuthentication;
}
