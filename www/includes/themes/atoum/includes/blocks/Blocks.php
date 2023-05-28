<?php

function chipTag(Tag $tag): string
{
    return '<a href="#" class="chip">' . $tag->display() . '</a>';
}

function chipActor(Actor $actor): string
{
    return '<a href="#" class="chip">' . $actor->display() . '</a>';
}

function spinner0(): string
{
    return '<div class="spinner0"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
}