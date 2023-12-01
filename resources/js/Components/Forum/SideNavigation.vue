<script setup>
import { Link } from '@inertiajs/vue3'

</script>


<template>
     <aside class="hidden md:block md:sticky p-3">
        <slot />
        <!-- sidebar filter options for all (auth & guest) -->
        <ul class="flex flex-col space-y-3">
            <li class="list-none">
                <Link
                    href="/"
                    class="inline-block p-3 w-full hover:text-blue-400 hover:bg-blue-100
                    rounded-xl transition-colors duration-200 text-sm font-semibold"
                    :class="{ 'bg-blue-100 text-blue-400': ! $page.props.queryStrings?.filter && $page.component === 'Forum/Index' }"
                >
                    <span
                    class="bg-gray-300 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"
                    :class="{ '!bg-blue-400': ! $page.props.queryStrings?.filter && $page.component === 'Forum/Index' }"
                    >
                    </span>
                    All Threads
                </Link>
            </li>
            <li class="list-none">
                <Link
                    href="/?filter[noreplies]=1"
                    class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3 w-full rounded-xl
                    transition-colors duration-200 text-sm font-semibold"
                    :class="{'bg-blue-100 text-blue-400': $page.props.queryStrings?.filter?.noreplies }"
                >
                    <span
                        class="bg-gray-300 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"
                        :class="{ '!bg-blue-400': $page.props.queryStrings?.filter?.noreplies }"
                    >
                    </span>
                    No Replies Yet
                </Link>
            </li>
            <li class="list-none">
                <Link
                    href="/?filter[resolved]=1"
                    class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3
                        w-full rounded-xl transition-colors duration-200 text-sm font-semibold"
                    :class="{ 'bg-blue-100 text-blue-400': $page.props.queryStrings?.filter?.resolved }"
                >
                    <span
                        class="bg-gray-300 hover w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"
                        :class="{ '!bg-blue-400': $page.props.queryStrings?.filter?.resolved }"
                    >
                    </span>
                    Resolved
                </Link>
            </li>
            <li class="list-none">
                <Link
                    href="/?filter[unresolved]=1"
                    class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3 w-full
                    rounded-xl transition-colors duration-200 text-sm font-semibold"
                    :class="{ 'bg-blue-100 text-blue-400': $page.props.queryStrings?.filter?.unresolved }"
                >
                    <span
                        class="bg-gray-300 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"
                        :class="{ '!bg-blue-400': $page.props.queryStrings?.filter?.unresolved }"
                    >
                    </span>
                    Unresolved
                </Link>
            </li>
        </ul>
        <!-- filter options for auth user only -->
        <ul class="flex flex-col space-y-3 mt-3" v-if="$page.props.auth.user">
            <li class="list-none">
                <Link
                    href="/?filter[participating]=1"
                    class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3 w-full rounded-xl
                    transition-colors duration-200 text-sm font-semibold"
                    :class="{ 'bg-blue-100 text-blue-400': $page.props.queryStrings?.filter?.participating }"
                >
                    <span
                    class="bg-gray-300 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"
                    :class="{ '!bg-blue-400': $page.props.queryStrings?.filter?.participating }"
                    >
                    </span>
                    Participating
                </Link>
            </li>
            <li class="list-none">
                <Link
                    href="/?filter[mine]=1"
                    class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3 w-full rounded-xl
                    transition-colors duration-200 text-sm font-semibold"
                    :class="{'bg-blue-100 text-blue-400': $page.props.queryStrings?.filter?.mine }"
                >
                    <span
                        class="bg-gray-300 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"
                        :class="{ '!bg-blue-400': $page.props.queryStrings?.filter?.mine }"
                    >
                    </span>
                    My Threads
                </Link>
            </li>
            <li class="list-none">
                <Link
                    href="/?filter[mentioned]=1"
                    class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3 w-full rounded-xl
                    transition-colors duration-200 text-sm font-semibold"
                    :class="{'bg-blue-100 text-blue-400': $page.props.queryStrings?.filter?.mentioned }"
                >
                    <span
                        class="bg-gray-300 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"
                        :class="{ '!bg-blue-400': $page.props.queryStrings?.filter?.mentioned }"
                    >
                    </span>
                    Mentioned
                </Link>
            </li>
        </ul>
    </aside>
</template>
