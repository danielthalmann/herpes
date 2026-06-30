<script lang="ts">
    import { onMount } from 'svelte';

    export type CalendarEvent = {
        id: string;
        ticket_id: string;
        start: string;    // ISO datetime "2024-01-15T09:00:00"
        end: string;      // ISO datetime "2024-01-15T10:30:00"
        comment?: string;
        color?: string;   // blue | green | purple | orange | pink | teal | red
        allDay?: boolean;
    };

    let { events = [], onEventClick, onSlotClick, onWeekChange }: {
        events?: CalendarEvent[];
        onEventClick?: (event: CalendarEvent) => void;
        onSlotClick?: (date: Date) => void;
        onWeekChange?: (start: Date, end: Date) => void;
    } = $props();

    const HOUR_HEIGHT = 64; // px per hour
    const HOURS = Array.from({ length: 24 }, (_, i) => i);
    const DAY_NAMES = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

    const EVENT_COLORS: Record<string, string> = {
        blue:   'bg-blue-500 border-blue-600 text-white',
        green:  'bg-emerald-500 border-emerald-600 text-white',
        purple: 'bg-violet-500 border-violet-600 text-white',
        orange: 'bg-orange-400 border-orange-500 text-white',
        pink:   'bg-pink-500 border-pink-600 text-white',
        teal:   'bg-teal-500 border-teal-600 text-white',
        red:    'bg-red-500 border-red-600 text-white',
    };

    let currentWeekStart = $state(getWeekStart(new Date()));
    let now = $state(new Date());
    let gridEl: HTMLDivElement | undefined = $state();

    function getWeekStart(date: Date): Date {
        const d = new Date(date);
        d.setHours(0, 0, 0, 0);
        const day = d.getDay();
        d.setDate(d.getDate() - (day === 0 ? 6 : day - 1)); // Monday first
        return d;
    }

    let weekDays = $derived(
        Array.from({ length: 7 }, (_, i) => {
            const d = new Date(currentWeekStart);
            d.setDate(d.getDate() + i);
            return d;
        })
    );

    let weekLabel = $derived(() => {
        const start = weekDays[0];
        const end = weekDays[6];
        const startMonth = start.toLocaleDateString('fr-FR', { month: 'long' });
        const endMonth = end.toLocaleDateString('fr-FR', { month: 'long' });
        const year = end.getFullYear();
        if (startMonth === endMonth) {
            return `${startMonth} ${year}`;
        }
        return `${startMonth} – ${endMonth} ${year}`;
    });

    let currentTimeTop = $derived((now.getHours() + now.getMinutes() / 60) * HOUR_HEIGHT);

    let isCurrentWeek = $derived(
        weekDays.some(d => d.toDateString() === new Date().toDateString())
    );

    $effect(() => {
        const start = weekDays[0];
        const end = weekDays[6];
        onWeekChange?.(start, end);
    });

    function prevWeek() {
        const d = new Date(currentWeekStart);
        d.setDate(d.getDate() - 7);
        currentWeekStart = d;
    }

    function nextWeek() {
        const d = new Date(currentWeekStart);
        d.setDate(d.getDate() + 7);
        currentWeekStart = d;
    }

    function goToday() {
        currentWeekStart = getWeekStart(new Date());
        scrollToNow();
    }

    function isToday(date: Date): boolean {
        return date.toDateString() === new Date().toDateString();
    }

    function sameDay(a: Date, b: Date): boolean {
        return a.toDateString() === b.toDateString();
    }

    function handleSlotClick(e: MouseEvent, day: Date) {
        const minutes = Math.round((e.offsetY / HOUR_HEIGHT) * 60 / 15) * 15;
        const date = new Date(day);
        date.setHours(Math.floor(minutes / 60), minutes % 60, 0, 0);
        onSlotClick?.(date);
    }

    function getTimedEventsForDay(day: Date): CalendarEvent[] {
        return events.filter(e => !e.allDay && sameDay(new Date(e.start), day));
    }

    function getAllDayEventsForDay(day: Date): CalendarEvent[] {
        return events.filter(e => e.allDay && sameDay(new Date(e.start), day));
    }

    function eventTop(event: CalendarEvent): number {
        const s = new Date(event.start);
        return (s.getHours() + s.getMinutes() / 60) * HOUR_HEIGHT;
    }

    function eventHeight(event: CalendarEvent): number {
        const s = new Date(event.start);
        const e = new Date(event.end);
        const hours = (e.getTime() - s.getTime()) / 3_600_000;
        return Math.max(hours * HOUR_HEIGHT, HOUR_HEIGHT * 0.25);
    }

    function eventColorClass(event: CalendarEvent): string {
        return EVENT_COLORS[event.color ?? 'blue'] ?? EVENT_COLORS.blue;
    }

    function formatHour(h: number): string {
        return `${String(h).padStart(2, '0')}:00`;
    }

    function formatTimeRange(event: CalendarEvent): string {
        const fmt = (d: string) =>
            new Date(d).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        return `${fmt(event.start)} – ${fmt(event.end)}`;
    }

    function scrollToNow() {
        if (!gridEl) return;
        const target = currentTimeTop - 120;
        gridEl.scrollTo({ top: Math.max(0, target), behavior: 'smooth' });
    }

    onMount(() => {
        scrollToNow();
        const id = setInterval(() => { now = new Date(); }, 60_000);
        return () => clearInterval(id);
    });
</script>

<div class="flex flex-col bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden h-full">

    <!-- ── Navigation ── -->
    <div class="flex items-center justify-between px-4 py-2.5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shrink-0">
        <div class="flex items-center gap-1.5">
            <button
                onclick={goToday}
                class="px-3 py-1 text-sm font-medium rounded-md border border-gray-300 dark:border-gray-600
                       text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
            >
                Aujourd'hui
            </button>
            <button
                onclick={prevWeek}
                class="p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-500 dark:text-gray-400"
                aria-label="Semaine précédente"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button
                onclick={nextWeek}
                class="p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-500 dark:text-gray-400"
                aria-label="Semaine suivante"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <h2 class="text-sm font-semibold capitalize text-gray-800 dark:text-gray-100 tracking-wide">
            {weekLabel()}
        </h2>

        <!-- spacer to center the title -->
        <div class="w-32"></div>
    </div>

    <!-- ── Day headers ── -->
    <div class="flex border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shrink-0">
        <div class="w-14 shrink-0"></div>
        {#each weekDays as day, i}
            {@const today = isToday(day)}
            <div class="flex-1 flex flex-col items-center py-2
                        {i < 6 ? 'border-r border-gray-100 dark:border-gray-700' : ''}">
                <span class="text-xs font-medium tracking-widest uppercase
                             {today ? 'text-blue-500' : 'text-gray-400 dark:text-gray-500'}">
                    {DAY_NAMES[i]}
                </span>
                <span class="mt-1 w-8 h-8 flex items-center justify-center rounded-full text-sm font-semibold
                             {today
                                ? 'bg-blue-500 text-white'
                                : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'}
                             transition-colors cursor-default">
                    {day.getDate()}
                </span>
            </div>
        {/each}
    </div>

    <!-- ── All-day row ── -->
    <div class="flex border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/40 shrink-0 min-h-7">
        <div class="w-14 shrink-0 flex items-start justify-end pr-2 pt-1">
            <span class="text-[10px] text-gray-400 dark:text-gray-600 uppercase tracking-wider">full</span>
        </div>
        {#each weekDays as day, i}
            <div class="flex-1 px-0.5 py-0.5 {i < 6 ? 'border-r border-gray-100 dark:border-gray-700' : ''}">
                {#each getAllDayEventsForDay(day) as event}
                    <button
                        onclick={() => onEventClick?.(event)}
                        class="w-full text-left text-[11px] px-1.5 py-0.5 rounded mb-0.5 truncate font-medium border-l-2
                               {eventColorClass(event)} hover:opacity-90 transition-opacity"
                    >
                        {event.comment ?? ''}
                    </button>
                {/each}
            </div>
        {/each}
    </div>

    <!-- ── Scrollable time grid ── -->
    <div bind:this={gridEl} class="flex-1 overflow-y-auto overflow-x-hidden max-h-96">
        <div class="flex" style="height: {24 * HOUR_HEIGHT}px; min-height: {24 * HOUR_HEIGHT}px;">

            <!-- Time gutter -->
            <div class="w-14 shrink-0 relative select-none">
                {#each HOURS as h}
                    {#if h > 0}
                        <div
                            class="absolute right-2 text-[11px] text-gray-400 dark:text-gray-500 leading-none"
                            style="top: {h * HOUR_HEIGHT - 7}px;"
                        >
                            {formatHour(h)}
                        </div>
                    {/if}
                {/each}
            </div>

            <!-- Columns -->
            <div class="flex flex-1 relative">

                <!-- Hour lines (shared, behind columns) -->
                {#each HOURS as h}
                    <div
                        class="absolute left-0 right-0 border-t border-gray-100 dark:border-gray-700/70 pointer-events-none"
                        style="top: {h * HOUR_HEIGHT}px;"
                    ></div>
                {/each}

                <!-- Current time indicator -->
                {#if isCurrentWeek}
                    <div
                        class="absolute left-0 right-0 z-20 pointer-events-none flex items-center"
                        style="top: {currentTimeTop}px;"
                    >
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0 -ml-1.5 shadow-sm"></div>
                        <div class="flex-1 h-px bg-red-500"></div>
                    </div>
                {/if}

                <!-- Day columns -->
                {#each weekDays as day, i}
                    {@const today = isToday(day)}
                    <div class="flex-1 relative cursor-cell
                                {i < 6 ? 'border-r border-gray-100 dark:border-gray-700' : ''}
                                {today ? 'bg-blue-50/40 dark:bg-blue-900/5' : ''}"
                         role="button" tabindex="0"
                         onclick={(e) => handleSlotClick(e, day)}
                         onkeydown={(e) => e.key === 'Enter' && handleSlotClick(e as unknown as MouseEvent, day)}>

                        <!-- Half-hour dashed lines -->
                        {#each HOURS as h}
                            <div
                                class="absolute left-0 right-0 border-t border-dashed border-gray-100 dark:border-gray-700/40 pointer-events-none"
                                style="top: {h * HOUR_HEIGHT + HOUR_HEIGHT / 2}px;"
                            ></div>
                        {/each}

                        <!-- Events -->
                        {#each getTimedEventsForDay(day) as event}
                            {@const height = eventHeight(event)}
                            <button
                                onclick={(e) => { e.stopPropagation(); onEventClick?.(event); }}
                                class="absolute left-0.5 right-0.5 rounded-md px-1.5 py-0.5 overflow-hidden
                                       text-left text-xs border-l-[3px] shadow-sm z-10
                                       {eventColorClass(event)}
                                       hover:brightness-110 hover:shadow-md transition-all"
                                style="top: {eventTop(event)}px; height: {height}px;"
                            >
                                <div class="font-semibold truncate leading-tight">{event.comment ?? ''}</div>
                                {#if height >= HOUR_HEIGHT * 0.6}
                                    <div class="opacity-80 text-[10px] truncate leading-tight mt-0.5">
                                        {formatTimeRange(event)}
                                    </div>
                                {/if}
                            </button>
                        {/each}
                    </div>
                {/each}
            </div>
        </div>
    </div>
</div>
