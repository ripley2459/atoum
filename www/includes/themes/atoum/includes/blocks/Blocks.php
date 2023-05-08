<?php

function chipTag(Tag $tag): string
{
    return '<a href="#" class="chip">' . $tag->display() . '</a>';
}

function chipActor(Actor $actor): string
{
    return '<a href="#" class="chip">' . $actor->display() . '</a>';
}