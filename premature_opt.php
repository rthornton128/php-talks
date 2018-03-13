<?php

/**
 * Introduction
 * --------
 * Premature optimization is the act of trying to optimize code without
 * knowing if it is necessary.
 *
 * There are two types of premature optimization you can do. The first is
 * what I call micro-level optimization. This is optimizing specific pieces
 * of code to improve speed or memory through techniques like loop
 * optimization or reducing memory allocations.
 *
 * The second, and the one the is the main topic I'll be discussing, is what
 * I call macro-level optimization. This includes things like choosing to
 * optimize for speed via techniques like page caching and reducing API
 * calls.
 *
 * Both techniques require varying degrees of expertise to fully realize or
 * even understand the effects of the changes being made. Both also fall
 * victim to the same typical pitfall: optimizing when the opportunity for
 * gains are unknown.
 *
 * To know if something is worth doing you need to investigate the potential
 * payoffs and that's the topic I'll be discussing today.
 *
 * Balance
 * -------
 * In development we are always waging a constant battle between providing
 * a good product and time. Many of our decisions are finding the best
 * solutions with the minimal wastage of time. They key term is is wastage.
 * Some tasks take a long time to do well and the payoffs are worth it. Other
 * tasks take a long time but realize minimal gains.
 *
 * There are typically two, sometimes competing, resources that we tend
 * to optimize for: memory and CPU. You may choose to optimize only for
 * one resource but there are instances where you need to improve the
 * consumption of both.
 *
 * You can spend hours or days improving a piece of code but if that slow
 * function is only used in a background process that never affects the user
 * then what is the benefit? Even if the user interacts with the code, if
 * the speed difference has no impact on the user experience then why are you
 * spending time working on it?
 *
 * The key is to find the cases where a problem exists. In fact, in an effort
 * to improve speed you can end up having the opposite result. Perhaps you
 * set up some aggressive caching service on your site but instead of seeing
 * a benefit on page loads you now spend more time invalidating caches and
 * rebuilding them. In the end you have a net negative impact on your site.
 *
 * Of course, if you never measure the performance in the first place how
 * would you ever know?
 *
 * Measure Twice, Cut Once
 * -----------------------
 * It feels a bit silly to use an axiom from the woodworking trade but it
 * fits surprisingly well. While we can't take a tape measure to a piece of
 * code to see if it should be optimized there are other tools that can be
 * used. Namely, tools use for what is called *profiling*.
 *
 * A common tool for profiling PHP scripts is xdebug. It resides in memory
 * while a program runs gather information on what functions are being
 * called, how long each call takes, and how much memory was consumed.
 *
 * Without profiling a piece of software there is no way to know where the
 * bottleneck is happening or if there is any one bottleneck at all.
 *
 * By way of example, perhaps you wrote a piece of software that fetches
 * a list of users from the database based on criteria like age or location.
 * The software then sorts the list based on user input. The software is
 * very slow with some requests taking several seconds. What is the problem?
 *
 * The answers are many. Some examples may be:
 * 1. The query to the database is slow.
 * 2. The sorting algorithm is slow.
 * 3. The connection to the database or API is slow.
 * 4. The program is consuming vast amounts of memory causing the system
 *   to thrash from excessive swapping.
 * 5. The garbage collector for the language is having to clean up excessive
 *   amounts of garbage being created.
 * 6. The function that processes the request is slow.
 *
 * You could spend hours trying to improve any one of those things while
 * never fixing the problem. Figure out where the slowdown is before you
 * try and improve it.
 *
 *
 */
