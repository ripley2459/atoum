<?php

enum EContentStatus: int
{
    case DELETED = 0;
    case PUBLISHED = 1;
    case ARCHIVED = 2;
    case HIDDEN = 3;
}
