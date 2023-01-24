<?php

enum EContentStatus: int
{
    case PUBLISHED = 0;
    case HIDDEN = 1;
    case ARCHIVED = 2;
    case DELETED = 3;
}
