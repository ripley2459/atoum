<?php

function chipTag(Tag $tag): string
{
    return '<a href="#" class="chip">' . $tag->getName() . '</a>';
}

function chipActor(Actor $actor): string
{
    return '<a href="#" class="chip">' . $actor->getName() . '</a>';
}


function spinner0(): string
{
    return '<div class="spinner0"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
}