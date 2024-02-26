<?php

Vote::register([[intval(R::getParameter('data'))], [0], [intval(R::getParameter('vote'))]]);

/**
 * TODO
 * - Prevent the user to like/dislike multiple times: check with auth the user id. If a vote with the content id and the user id exist -> do nothing.
 */