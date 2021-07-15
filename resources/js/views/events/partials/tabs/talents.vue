<template>
    <div>
        <b-row>
            <b-col>
                <b-tabs
                    justified
                    nav-class="nav-tabs-custom"
                    content-class="p-3 text-muted"
                >
                    <b-tab>
                        <template #title>
                            <span class="d-inline-block d-sm-none">
                                <i class="fas fa-home" />
                            </span>
                            <span class="d-none d-sm-inline-block"
                                >Summary</span
                            >
                        </template>

                        <b-row class="mt-3">
                            <b-col>
                                <b-card
                                    v-for="(stage, summaryIdx) in talentSummary"
                                    :key="stage.id"
                                    class="activity stage-activity"
                                    :title="stage.name"
                                    style="box-shadow: 1px 1px 8px 0"
                                >
                                    
                                    <b-row class="mt-4">
                                        <b-col>
                                            <b-tabs
                                                justified
                                                nav-class="nav-tabs-custom"
                                                content-class="p-3 text-muted"
                                            >
                                                <b-tab
                                                    v-for="(slotObj,
                                                    idx) in stage.slots"
                                                    :key="idx"
                                                >
                                                    <template #title>
                                                        <span
                                                            class="d-inline-block d-sm-none"
                                                        >
                                                            <i
                                                                class="fas fa-home"
                                                            />
                                                        </span>
                                                        <span
                                                            class="d-none d-sm-inline-block"
                                                            >{{
                                                                slotObj.formatted
                                                            }}</span
                                                        >
                                                    </template>

                                                    <b-row>
                                                        <b-col>
                                                            <b-list-group>
                                                                <b-list-group-item
                                                                    v-for="(artist,
                                                                    index) in slotObj.artists"
                                                                    :id="
                                                                        'slot_popover_summary_' +
                                                                            summaryIdx +
                                                                            '_slot_' +
                                                                            idx +
                                                                            '_artist_' +
                                                                            index
                                                                    "
                                                                    :key="index"
                                                                    class="
                                    d-flex
                                    justify-content-between
                                    align-items-center
                                  "
                                                                    href="javascript:void(0)"
                                                                    @click="
                                                                        edit(
                                                                            artist
                                                                        )
                                                                    "
                                                                >
                                                                    {{
                                                                        artist.status
                                                                    }}({{
                                                                        artist.hold_position
                                                                    }}) -
                                                                    {{
                                                                        artist.name
                                                                    }}
                                                                    <b-img
                                                                        :src="
                                                                            artist.image
                                                                        "
                                                                        rounded="circle"
                                                                        width="50px"
                                                                    />
                                                                    <b-popover
                                                                        :target="
                                                                            'slot_popover_summary_' +
                                                                                summaryIdx +
                                                                                '_slot_' +
                                                                                idx +
                                                                                '_artist_' +
                                                                                index
                                                                        "
                                                                        triggers="hover"
                                                                        placement="auto"
                                                                    >
                                                                        <b-row>
                                                                            <b-col>
                                                                                <b-card
                                                                                    title="Test Title"
                                                                                    style="box-shadow: 1px 1px 8px 0"
                                                                                >
                                                                                    <b-card-header
                                                                                        v-if="
                                                                                            fetchStatus(
                                                                                                artist.status,
                                                                                                'key'
                                                                                            ) ===
                                                                                                7
                                                                                        "
                                                                                    >
                                                                                        <vue-countdown-timer
                                                                                            :start-time="
                                                                                                currentUtcDate(
                                                                                                    'YYYY-MM-DD HH:mm:ss'
                                                                                                )
                                                                                            "
                                                                                            :end-time="
                                                                                                utcTimestamp(
                                                                                                    artist.offer_expiration_date
                                                                                                )
                                                                                            "
                                                                                            :interval="
                                                                                                1000
                                                                                            "
                                                                                            :start-label="
                                                                                                'Start:'
                                                                                            "
                                                                                            :end-label="
                                                                                                'End:'
                                                                                            "
                                                                                            label-position="begin"
                                                                                            :end-text="
                                                                                                'Offer Expired'
                                                                                            "
                                                                                            :day-txt="
                                                                                                'Days'
                                                                                            "
                                                                                            :hour-txt="
                                                                                                'Hours'
                                                                                            "
                                                                                            :minutes-txt="
                                                                                                'Min'
                                                                                            "
                                                                                            :seconds-txt="
                                                                                                'Sec'
                                                                                            "
                                                                                        />
                                                                                    </b-card-header>
                                                                                    <b-card-header
                                                                                        v-if="
                                                                                            [
                                                                                                5,
                                                                                                12,
                                                                                            ].includes(
                                                                                                fetchStatus(
                                                                                                    artist.status,
                                                                                                    'key'
                                                                                                )
                                                                                            ) &&
                                                                                                !!event.challenge
                                                                                        "
                                                                                    >
                                                                                        <vue-countdown-timer
                                                                                            :start-time="
                                                                                                currentUtcDate(
                                                                                                    'YYYY-MM-DD HH:mm:ss'
                                                                                                )
                                                                                            "
                                                                                            :end-time="
                                                                                                utcTimestamp(
                                                                                                    event
                                                                                                        .challenge
                                                                                                        .end_at
                                                                                                )
                                                                                            "
                                                                                            :interval="
                                                                                                1000
                                                                                            "
                                                                                            :start-label="
                                                                                                'Start:'
                                                                                            "
                                                                                            :end-label="
                                                                                                'Challenge Expires In:-'
                                                                                            "
                                                                                            label-position="begin"
                                                                                            :end-text="
                                                                                                'Challenge Expired!'
                                                                                            "
                                                                                            :day-txt="
                                                                                                'Days'
                                                                                            "
                                                                                            :hour-txt="
                                                                                                ':'
                                                                                            "
                                                                                            :minutes-txt="
                                                                                                ':'
                                                                                            "
                                                                                            :seconds-txt="
                                                                                                ''
                                                                                            "
                                                                                        />
                                                                                    </b-card-header>
                                                                                    <b-card-title>
                                                                                        <span
                                                                                            v-if="
                                                                                                artist.status ===
                                                                                                    'Archived' ||
                                                                                                    artist.status ===
                                                                                                        'Released By Artist' ||
                                                                                                    artist.status ===
                                                                                                        'Rescinded By Venue'
                                                                                            "
                                                                                            class="artist_status_text"
                                                                                            style="
                                                background-color: #ffffff;
                                                color: #808080;
                                              "
                                                                                            >{{
                                                                                                artist.status
                                                                                            }}</span
                                                                                        >
                                                                                        <span
                                                                                            v-else
                                                                                            class="artist_status_text"
                                                                                            :style="
                                                                                                artist.status_color
                                                                                            "
                                                                                            >{{
                                                                                                artist.status
                                                                                            }}</span
                                                                                        >
                                                                                        <span
                                                                                            v-if="
                                                                                                artist.status ===
                                                                                                    'Declined' ||
                                                                                                    artist.status ===
                                                                                                        'Not Available' ||
                                                                                                    artist.status ===
                                                                                                        'Released By Artist' ||
                                                                                                    artist.status ===
                                                                                                        'Rescinded By Venue'
                                                                                            "
                                                                                            class="artist_hold_text"
                                                                                            style="
                                                background-color: #808080;
                                                color: #000000;
                                              "
                                                                                            >{{
                                                                                                artist.hold_position
                                                                                            }}</span
                                                                                        >
                                                                                        <span
                                                                                            v-else
                                                                                            class="artist_hold_text"
                                                                                            :style="
                                                                                                artist.hold_position_color
                                                                                            "
                                                                                            >{{
                                                                                                artist.hold_position
                                                                                            }}</span
                                                                                        >
                                                                                    </b-card-title>
                                                                                    <hr
                                                                                        v-if="
                                                                                            artist.status ===
                                                                                                'Mutually Agreed Date' ||
                                                                                                artist.status ===
                                                                                                    'Declined'
                                                                                        "
                                                                                    />
                                                                                    <p
                                                                                        v-if="
                                                                                            artist.status ===
                                                                                                'Mutually Agreed Date' ||
                                                                                                artist.status ===
                                                                                                    'Declined'
                                                                                        "
                                                                                    >
                                                                                        <span
                                                                                            >{{
                                                                                                artist.date_notes
                                                                                            }}</span
                                                                                        >
                                                                                    </p>
                                                                                    <hr
                                                                                        v-if="
                                                                                            [
                                                                                                5,
                                                                                                12,
                                                                                            ].includes(
                                                                                                fetchStatus(
                                                                                                    artist.status,
                                                                                                    'key'
                                                                                                )
                                                                                            )
                                                                                        "
                                                                                    />
                                                                                    <p
                                                                                        v-if="
                                                                                            [
                                                                                                5,
                                                                                                12,
                                                                                            ].includes(
                                                                                                fetchStatus(
                                                                                                    artist.status,
                                                                                                    'key'
                                                                                                )
                                                                                            ) &&
                                                                                                !!event.challenge
                                                                                        "
                                                                                    >
                                                                                        <span>
                                                                                            Hold
                                                                                            position
                                                                                            1
                                                                                            (
                                                                                            {{
                                                                                                event
                                                                                                    .challenge
                                                                                                    .to
                                                                                                    .name
                                                                                            }})
                                                                                            is
                                                                                            challenged
                                                                                            by
                                                                                            Hold
                                                                                            position
                                                                                            2
                                                                                            ({{
                                                                                                event
                                                                                                    .challenge
                                                                                                    .by
                                                                                                    .name
                                                                                            }})
                                                                                        </span>
                                                                                    </p>
                                                                                    <hr />
                                                                                    <b-card-text>
                                                                                        <b-img
                                                                                            :src="
                                                                                                artist.image
                                                                                            "
                                                                                            class="rounded-circle"
                                                                                            width="50px"
                                                                                            height="50px"
                                                                                        />
                                                                                        <span
                                                                                            style="font-size: 16px"
                                                                                            >{{
                                                                                                artist.name
                                                                                            }}</span
                                                                                        >
                                                                                        <span
                                                                                            class="ml-1"
                                                                                            :style="{
                                                                                                fontWeight:
                                                                                                    'bold',
                                                                                                color:
                                                                                                    'royalblue',
                                                                                            }"
                                                                                            >(${{
                                                                                                artist.amount
                                                                                            }})</span
                                                                                        ><br />
                                                                                    </b-card-text>
                                                                                    <b-card-text
                                                                                        class="ml-2 mb-4"
                                                                                        style="margin-top: -20px"
                                                                                    >
                                                                                        <p
                                                                                            class="ml-5"
                                                                                        >
                                                                                            {{
                                                                                                artist.email
                                                                                            }}
                                                                                        </p>
                                                                                        <b-card-sub-title
                                                                                            v-for="(activity,
                                                                                            actIdx) in artist.my_activities"
                                                                                            :key="
                                                                                                activity
                                                                                                    .stage
                                                                                                    .id
                                                                                            "
                                                                                            class="ml-5"
                                                                                        >
                                                                                            <b
                                                                                                class="font-size-14"
                                                                                                >{{
                                                                                                    activity
                                                                                                        .stage
                                                                                                        .name
                                                                                                }} </b
                                                                                            ><br />
                                                                                            Time
                                                                                            Slots:-
                                                                                            <span
                                                                                                v-for="(time_slot,
                                                                                                tsIdx) in activity.slots"
                                                                                                :key="
                                                                                                    tsIdx
                                                                                                "
                                                                                            >
                                                                                                {{
                                                                                                    formatDate(
                                                                                                        time_slot
                                                                                                            .time
                                                                                                            .start,
                                                                                                        "hh:mm A"
                                                                                                    )
                                                                                                }}
                                                                                                -
                                                                                                {{
                                                                                                    formatDate(
                                                                                                        time_slot
                                                                                                            .time
                                                                                                            .end,
                                                                                                        "hh:mm A"
                                                                                                    )
                                                                                                }}<span
                                                                                                    v-if="
                                                                                                        tsIdx !==
                                                                                                            activity
                                                                                                                .slots
                                                                                                                .length -
                                                                                                                1
                                                                                                    "
                                                                                                    >,
                                                                                                </span>
                                                                                            </span>
                                                                                            <br
                                                                                                v-if="
                                                                                                    actIdx !==
                                                                                                        artist
                                                                                                            .my_activities
                                                                                                            .length -
                                                                                                            1
                                                                                                "
                                                                                            />
                                                                                            <br
                                                                                                v-if="
                                                                                                    actIdx !==
                                                                                                        artist
                                                                                                            .my_activities
                                                                                                            .length -
                                                                                                            1
                                                                                                "
                                                                                            />
                                                                                        </b-card-sub-title>
                                                                                        <span
                                                                                            class="ml-5"
                                                                                        >
                                                                                            {{
                                                                                                artist.notes
                                                                                            }}
                                                                                        </span>
                                                                                    </b-card-text>
                                                                                    <b-button
                                                                                        variant="outline-primary"
                                                                                        @click="
                                                                                            edit(
                                                                                                artist
                                                                                            )
                                                                                        "
                                                                                    >
                                                                                        Edit
                                                                                    </b-button>
                                                                                    <b-button
                                                                                        variant="outline-danger"
                                                                                        @click="
                                                                                            remove(
                                                                                                artist
                                                                                            )
                                                                                        "
                                                                                    >
                                                                                        Delete
                                                                                    </b-button>
                                                                                </b-card>
                                                                            </b-col>
                                                                        </b-row>
                                                                    </b-popover>
                                                                </b-list-group-item>
                                                            </b-list-group>
                                                        </b-col>
                                                    </b-row>
                                                </b-tab>
                                            </b-tabs>
                                        </b-col>
                                    </b-row>
                                </b-card>
                                <div v-b-toggle="`history_collapse_1`" class="bg-light font-weight-bold p-1 text-center">
                                    History
                                </div>
                                <b-collapse
                                    id="history_collapse_1"
                                >
                                    <b-card
                                        class="border rounded-sm shadow-sm"
                                    >
                                        <div
                                            v-for="(getHistory,
                                            historyIdx) in talentHistory"
                                            :key="historyIdx"
                                        >
                                            <b-col
                                                class="border col mb-1 p-2"
                                            >
                                                {{ getHistory.artistName }}/
                                                {{ getHistory.status }}/
                                                {{
                                                    getHistory.hold_position
                                                }}/
                                                {{ getHistory.stage_name }}/
                                                {{
                                                    formatDate(
                                                        getHistory.startTime,
                                                        "DD-MM-YYYY"
                                                    )
                                                }}
                                                /
                                                {{
                                                    formatDate(
                                                        getHistory.startTime,
                                                        "hh:mm A"
                                                    )
                                                }}
                                                -
                                                {{
                                                    formatDate(
                                                        getHistory.endTime,
                                                        "hh:mm A"
                                                    )
                                                }}/ {{ getHistory.price }}/
                                                {{ getHistory.offer_term }}/
                                                {{ getHistory.notes }}
                                            </b-col>
                                        </div>
                                    </b-card>
                                </b-collapse>
                            </b-col>
                        </b-row>
                    </b-tab>

                    <b-tab>
                        <template #title>
                            <span class="d-inline-block d-sm-none">
                                <i class="fas fa-home" />
                            </span>
                            <span class="d-none d-sm-inline-block"
                                >Management</span
                            >
                        </template>

                        <b-row class="mb-5">
                            <b-col>
                                <b-button
                                    v-if="initiated"
                                    variant="outline-primary"
                                    @click="add"
                                >
                                    Add Talent
                                </b-button>
                            </b-col>
                        </b-row>

                        <b-row class="mt-3">
                            <b-col>
                                <b-card style="box-shadow: 1px 1px 8px 0">
                                    <b-card-title class="talent_activity1">
                                        Headliners
                                    </b-card-title>
                                    <b-row class="mt-4">
                                        <b-col
                                            v-for="headliner in headliners"
                                            :key="headliner.id"
                                            md="4"
                                        >
                                            <b-card
                                                :title="headliner.title"
                                                style="box-shadow: 1px 1px 8px 0"
                                            >
                                                <b-card-header
                                                    v-if="
                                                        fetchStatus(
                                                            headliner.status,
                                                            'key'
                                                        ) === 7
                                                    "
                                                >
                                                    <vue-countdown-timer
                                                        :start-time="
                                                            currentUtcDate(
                                                                'YYYY-MM-DD HH:mm:ss'
                                                            )
                                                        "
                                                        :end-time="
                                                            utcTimestamp(
                                                                headliner.offer_expiration_date
                                                            )
                                                        "
                                                        :interval="1000"
                                                        :start-label="'Start:'"
                                                        :end-label="'End:'"
                                                        label-position="begin"
                                                        :end-text="
                                                            'Offer Expired'
                                                        "
                                                        :day-txt="'Days'"
                                                        :hour-txt="'Hours'"
                                                        :minutes-txt="'Min'"
                                                        :seconds-txt="'Sec'"
                                                    />
                                                </b-card-header>
                                                <b-card-header
                                                    v-if="
                                                        [5, 12].includes(
                                                            fetchStatus(
                                                                headliner.status,
                                                                'key'
                                                            )
                                                        ) && !!event.challenge
                                                    "
                                                >
                                                    <vue-countdown-timer
                                                        :start-time="
                                                            currentUtcDate(
                                                                'YYYY-MM-DD HH:mm:ss'
                                                            )
                                                        "
                                                        :end-time="
                                                            utcTimestamp(
                                                                event.challenge
                                                                    .end_at
                                                            )
                                                        "
                                                        :interval="1000"
                                                        :start-label="'Start:'"
                                                        :end-label="
                                                            'Challenge Expires In:-'
                                                        "
                                                        label-position="begin"
                                                        :end-text="
                                                            'Challenge Expired!'
                                                        "
                                                        :day-txt="'Days'"
                                                        :hour-txt="':'"
                                                        :minutes-txt="':'"
                                                        :seconds-txt="''"
                                                    />
                                                </b-card-header>
                                                <b-card-title>
                                                    <span
                                                        v-if="
                                                            headliner.status ===
                                                                'Archived' ||
                                                                headliner.status ===
                                                                    'Released By Artist' ||
                                                                headliner.status ===
                                                                    'Rescinded By Venue'
                                                        "
                                                        class="artist_status_text"
                                                        style="background-color: #ffffff; color: #808080"
                                                        >{{
                                                            headliner.status
                                                        }}</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="artist_status_text"
                                                        :style="
                                                            headliner.status_color
                                                        "
                                                        >{{
                                                            headliner.status
                                                        }}</span
                                                    >
                                                    <span
                                                        v-if="
                                                            headliner.status ===
                                                                'Declined' ||
                                                                headliner.status ===
                                                                    'Not Available' ||
                                                                headliner.status ===
                                                                    'Released By Artist' ||
                                                                headliner.status ===
                                                                    'Rescinded By Venue'
                                                        "
                                                        class="artist_hold_text"
                                                        style="background-color: #808080; color: #000000"
                                                        >{{
                                                            headliner.hold_position
                                                        }}</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="artist_hold_text"
                                                        :style="
                                                            headliner.hold_position_color
                                                        "
                                                        >{{
                                                            headliner.hold_position
                                                        }}</span
                                                    >
                                                </b-card-title>
                                                <hr
                                                    v-if="
                                                        headliner.status ===
                                                            'Mutually Agreed Date' ||
                                                            headliner.status ===
                                                                'Declined'
                                                    "
                                                />
                                                <p
                                                    v-if="
                                                        headliner.status ===
                                                            'Mutually Agreed Date' ||
                                                            headliner.status ===
                                                                'Declined'
                                                    "
                                                >
                                                    <span>{{
                                                        headliner.date_notes
                                                    }}</span>
                                                </p>
                                                <hr
                                                    v-if="
                                                        [5, 12].includes(
                                                            fetchStatus(
                                                                headliner.status,
                                                                'key'
                                                            )
                                                        )
                                                    "
                                                />
                                                <p
                                                    v-if="
                                                        [5, 12].includes(
                                                            fetchStatus(
                                                                headliner.status,
                                                                'key'
                                                            )
                                                        ) && !!event.challenge
                                                    "
                                                >
                                                    <span>
                                                        Hold position 1 (
                                                        {{
                                                            event.challenge.to
                                                                .name
                                                        }}) is challenged by
                                                        Hold position 2 ({{
                                                            event.challenge.by
                                                                .name
                                                        }})
                                                    </span>
                                                </p>
                                                <hr />
                                                <b-card-text>
                                                    <b-img
                                                        :src="headliner.image"
                                                        class="rounded-circle"
                                                        width="50px"
                                                        height="50px"
                                                    />
                                                    <span
                                                        style="font-size: 16px"
                                                        >{{
                                                            headliner.name
                                                        }}</span
                                                    >
                                                    <span
                                                        class="ml-1"
                                                        :style="{
                                                            fontWeight: 'bold',
                                                            color: 'royalblue',
                                                        }"
                                                        >(${{
                                                            headliner.amount
                                                        }})</span
                                                    ><br />
                                                </b-card-text>
                                                <b-card-text
                                                    class="ml-2 mb-4"
                                                    style="margin-top: -20px"
                                                >
                                                    <p class="ml-5">
                                                        {{ headliner.email }}
                                                    </p>
                                                    <b-card-sub-title
                                                        v-for="(activity,
                                                        idx) in headliner.my_activities"
                                                        :key="activity.stage.id"
                                                        class="ml-5"
                                                    >
                                                        <b class="font-size-14"
                                                            >{{
                                                                activity.stage
                                                                    .name
                                                            }} </b
                                                        ><br />
                                                        Time Slots:-
                                                        <span
                                                            v-for="(time_slot,
                                                            tsIdx) in activity.slots"
                                                            :key="tsIdx"
                                                        >
                                                            {{
                                                                formatDate(
                                                                    time_slot
                                                                        .time
                                                                        .start,
                                                                    "hh:mm A"
                                                                )
                                                            }}
                                                            -
                                                            {{
                                                                formatDate(
                                                                    time_slot
                                                                        .time
                                                                        .end,
                                                                    "hh:mm A"
                                                                )
                                                            }}<span
                                                                v-if="
                                                                    tsIdx !==
                                                                        activity
                                                                            .slots
                                                                            .length -
                                                                            1
                                                                "
                                                                >,
                                                            </span>
                                                        </span>
                                                        <br
                                                            v-if="
                                                                idx !==
                                                                    headliner
                                                                        .my_activities
                                                                        .length -
                                                                        1
                                                            "
                                                        />
                                                        <br
                                                            v-if="
                                                                idx !==
                                                                    headliner
                                                                        .my_activities
                                                                        .length -
                                                                        1
                                                            "
                                                        />
                                                    </b-card-sub-title>
                                                    <span class="ml-5">
                                                        {{ headliner.notes }}
                                                    </span>
                                                </b-card-text>
                                                <b-button
                                                    variant="outline-primary"
                                                    @click="edit(headliner)"
                                                >
                                                    Edit
                                                </b-button>
                                                <b-button
                                                    variant="outline-danger"
                                                    @click="remove(headliner)"
                                                >
                                                    Delete
                                                </b-button>
                                            </b-card>
                                        </b-col>
                                    </b-row>
                                </b-card>
                            </b-col>
                        </b-row>

                        <b-row class="mt-3">
                            <b-col>
                                <b-card style="box-shadow: 1px 1px 8px 0">
                                    <b-card-title class="talent_activity2">
                                        Support
                                    </b-card-title>
                                    <b-row class="mt-4">
                                        <b-col
                                            v-for="support in supports"
                                            :key="support.id"
                                            md="4"
                                        >
                                            <b-card
                                                :title="support.title"
                                                style="box-shadow: 1px 1px 8px 0"
                                            >
                                                <b-card-header
                                                    v-if="
                                                        fetchStatus(
                                                            support.status,
                                                            'key'
                                                        ) === 7
                                                    "
                                                >
                                                    <vue-countdown-timer
                                                        :start-time="
                                                            currentUtcDate(
                                                                'YYYY-MM-DD HH:mm:ss'
                                                            )
                                                        "
                                                        :end-time="
                                                            utcTimestamp(
                                                                support.offer_expiration_date
                                                            )
                                                        "
                                                        :interval="1000"
                                                        :start-label="'Start:'"
                                                        :end-label="'End:'"
                                                        label-position="begin"
                                                        :end-text="
                                                            'Offer Expired'
                                                        "
                                                        :day-txt="'Days'"
                                                        :hour-txt="'Hours'"
                                                        :minutes-txt="'Min'"
                                                        :seconds-txt="'Sec'"
                                                    />
                                                </b-card-header>
                                                <b-card-header
                                                    v-if="
                                                        [5, 12].includes(
                                                            fetchStatus(
                                                                support.status,
                                                                'key'
                                                            )
                                                        ) && !!event.challenge
                                                    "
                                                >
                                                    <vue-countdown-timer
                                                        :start-time="
                                                            currentUtcDate(
                                                                'YYYY-MM-DD HH:mm:ss'
                                                            )
                                                        "
                                                        :end-time="
                                                            utcTimestamp(
                                                                event.challenge
                                                                    .end_at
                                                            )
                                                        "
                                                        :interval="1000"
                                                        :start-label="'Start:'"
                                                        :end-label="
                                                            'Challenge Expires In:-'
                                                        "
                                                        label-position="begin"
                                                        :end-text="
                                                            'Challenge Expired!'
                                                        "
                                                        :day-txt="'Days'"
                                                        :hour-txt="':'"
                                                        :minutes-txt="':'"
                                                        :seconds-txt="''"
                                                    />
                                                </b-card-header>
                                                <b-card-title>
                                                    <span
                                                        v-if="
                                                            support.status ===
                                                                'Archived' ||
                                                                support.status ===
                                                                    'Released By Artist' ||
                                                                support.status ===
                                                                    'Rescinded By Venue'
                                                        "
                                                        class="artist_status_text"
                                                        style="background-color: #ffffff; color: #808080"
                                                        >{{
                                                            support.status
                                                        }}</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="artist_status_text"
                                                        :style="
                                                            support.status_color
                                                        "
                                                        >{{
                                                            support.status
                                                        }}</span
                                                    >
                                                    <span
                                                        v-if="
                                                            support.status ===
                                                                'Declined' ||
                                                                support.status ===
                                                                    'Not Available' ||
                                                                support.status ===
                                                                    'Released By Artist' ||
                                                                support.status ===
                                                                    'Rescinded By Venue'
                                                        "
                                                        class="artist_hold_text"
                                                        style="background-color: #808080; color: #000000"
                                                        >{{
                                                            support.hold_position
                                                        }}</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="artist_hold_text"
                                                        :style="
                                                            support.hold_position_color
                                                        "
                                                        >{{
                                                            support.hold_position
                                                        }}</span
                                                    >
                                                </b-card-title>
                                                <hr
                                                    v-if="
                                                        support.status ===
                                                            'Mutually Agreed Date'
                                                    "
                                                />
                                                <p
                                                    v-if="
                                                        support.status ===
                                                            'Mutually Agreed Date'
                                                    "
                                                >
                                                    <span>{{
                                                        support.date_notes
                                                    }}</span>
                                                </p>
                                                <hr
                                                    v-if="
                                                        [5, 12].includes(
                                                            fetchStatus(
                                                                support.status,
                                                                'key'
                                                            )
                                                        )
                                                    "
                                                />
                                                <p
                                                    v-if="
                                                        [5, 12].includes(
                                                            fetchStatus(
                                                                support.status,
                                                                'key'
                                                            )
                                                        ) && !!event.challenge
                                                    "
                                                >
                                                    <span>
                                                        Hold position 1 (
                                                        {{
                                                            event.challenge.to
                                                                .name
                                                        }}) is challenged by
                                                        Hold position 2 ({{
                                                            event.challenge.by
                                                                .name
                                                        }})
                                                    </span>
                                                </p>
                                                <hr />
                                                <b-card-text>
                                                    <b-img
                                                        :src="support.image"
                                                        class="rounded-circle"
                                                        width="50px"
                                                        height="50px"
                                                    />
                                                    <span
                                                        style="font-size: 16px"
                                                        >{{
                                                            support.name
                                                        }}</span
                                                    >
                                                    <span
                                                        class="ml-1"
                                                        :style="{
                                                            fontWeight: 'bold',
                                                            color: 'royalblue',
                                                        }"
                                                        >(${{
                                                            support.amount
                                                        }})</span
                                                    >
                                                </b-card-text>
                                                <b-card-text
                                                    class="ml-2 mb-4"
                                                    style="margin-top: -20px"
                                                >
                                                    <b-card-sub-title
                                                        v-for="(activity,
                                                        idx) in support.my_activities"
                                                        :key="activity.stage.id"
                                                        class="ml-5"
                                                    >
                                                        <b class="font-size-14"
                                                            >{{
                                                                activity.stage
                                                                    .name
                                                            }} </b
                                                        ><br />
                                                        Time Slots:-
                                                        <span
                                                            v-for="(time_slot,
                                                            tsIdx) in activity.slots"
                                                            :key="tsIdx"
                                                        >
                                                            {{
                                                                formatDate(
                                                                    time_slot
                                                                        .time
                                                                        .start,
                                                                    "hh:mm A"
                                                                )
                                                            }}
                                                            -
                                                            {{
                                                                formatDate(
                                                                    time_slot
                                                                        .time
                                                                        .end,
                                                                    "hh:mm A"
                                                                )
                                                            }}<span
                                                                v-if="
                                                                    tsIdx !==
                                                                        activity
                                                                            .slots
                                                                            .length -
                                                                            1
                                                                "
                                                                >,
                                                            </span>
                                                        </span>
                                                        <br
                                                            v-if="
                                                                idx !==
                                                                    support
                                                                        .my_activities
                                                                        .length -
                                                                        1
                                                            "
                                                        />
                                                        <br
                                                            v-if="
                                                                idx !==
                                                                    support
                                                                        .my_activities
                                                                        .length -
                                                                        1
                                                            "
                                                        />
                                                    </b-card-sub-title>
                                                    <span class="ml-5">{{
                                                        support.notes
                                                    }}</span>
                                                </b-card-text>
                                                <b-button
                                                    variant="outline-primary"
                                                    @click="edit(support)"
                                                >
                                                    Edit
                                                </b-button>
                                                <b-button
                                                    variant="outline-danger"
                                                    @click="remove(support)"
                                                >
                                                    Delete
                                                </b-button>
                                            </b-card>
                                        </b-col>
                                    </b-row>
                                </b-card>
                            </b-col>
                        </b-row>

                        <b-row class="mt-3">
                            <b-col>
                                <b-card style="box-shadow: 1px 1px 8px 0">
                                    <b-card-title class="talent_activity3">
                                        Historical
                                    </b-card-title>
                                    <b-row class="mt-4">
                                        <b-col
                                            v-for="artist in historical"
                                            :key="artist.id"
                                            md="4"
                                        >
                                            <b-card
                                                :title="artist.title"
                                                style="box-shadow: 1px 1px 8px 0"
                                            >
                                                <b-card-title>
                                                    <span
                                                        v-if="
                                                            artist.status ===
                                                                'Archived' ||
                                                                artist.status ===
                                                                    'Released By Artist' ||
                                                                artist.status ===
                                                                    'Rescinded By Venue'
                                                        "
                                                        class="artist_status_text"
                                                        style="background-color: #ffffff; color: #808080"
                                                        >{{
                                                            artist.status
                                                        }}</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="artist_status_text"
                                                        :style="
                                                            artist.status_color
                                                        "
                                                        >{{
                                                            artist.status
                                                        }}</span
                                                    >
                                                    <span
                                                        v-if="
                                                            artist.status ===
                                                                'Declined' ||
                                                                artist.status ===
                                                                    'Not Available' ||
                                                                artist.status ===
                                                                    'Released By Artist' ||
                                                                artist.status ===
                                                                    'Rescinded By Venue'
                                                        "
                                                        class="artist_hold_text"
                                                        style="background-color: #808080; color: #000000"
                                                        >{{
                                                            artist.hold_position
                                                        }}</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="artist_hold_text"
                                                        :style="
                                                            artist.hold_position_color
                                                        "
                                                        >{{
                                                            artist.hold_position
                                                        }}</span
                                                    >
                                                </b-card-title>
                                                <hr
                                                    v-if="
                                                        artist.status ===
                                                            'Mutually Agreed Date'
                                                    "
                                                />
                                                <p
                                                    v-if="
                                                        artist.status ===
                                                            'Mutually Agreed Date'
                                                    "
                                                >
                                                    <span>{{
                                                        artist.date_notes
                                                    }}</span>
                                                </p>
                                                <hr />
                                                <b-card-text>
                                                    <b-img
                                                        :src="artist.image"
                                                        class="rounded-circle"
                                                        width="50px"
                                                        height="50px"
                                                    />
                                                    <span
                                                        style="font-size: 16px"
                                                        >{{ artist.name }}</span
                                                    >
                                                    <span
                                                        class="ml-1"
                                                        :style="{
                                                            fontWeight: 'bold',
                                                            color: 'royalblue',
                                                        }"
                                                        >(${{
                                                            artist.amount
                                                        }})</span
                                                    >
                                                </b-card-text>
                                                <b-card-text
                                                    class="ml-2 mb-4"
                                                    style="margin-top: -20px"
                                                >
                                                    <b-card-sub-title
                                                        v-for="(activity,
                                                        idx) in artist.my_activities"
                                                        :key="activity.stage.id"
                                                        class="ml-5"
                                                    >
                                                        <b class="font-size-14"
                                                            >{{
                                                                activity.stage
                                                                    .name
                                                            }} </b
                                                        ><br />
                                                        Time Slots:-
                                                        <span
                                                            v-for="(time_slot,
                                                            tsIdx) in activity.slots"
                                                            :key="tsIdx"
                                                        >
                                                            {{
                                                                formatDate(
                                                                    time_slot
                                                                        .time
                                                                        .start,
                                                                    "hh:mm A"
                                                                )
                                                            }}
                                                            -
                                                            {{
                                                                formatDate(
                                                                    time_slot
                                                                        .time
                                                                        .end,
                                                                    "hh:mm A"
                                                                )
                                                            }}<span
                                                                v-if="
                                                                    tsIdx !==
                                                                        activity
                                                                            .slots
                                                                            .length -
                                                                            1
                                                                "
                                                                >,
                                                            </span>
                                                        </span>
                                                        <br
                                                            v-if="
                                                                idx !==
                                                                    artist
                                                                        .my_activities
                                                                        .length -
                                                                        1
                                                            "
                                                        />
                                                        <br
                                                            v-if="
                                                                idx !==
                                                                    artist
                                                                        .my_activities
                                                                        .length -
                                                                        1
                                                            "
                                                        />
                                                    </b-card-sub-title>
                                                    <span class="ml-5">{{
                                                        artist.notes
                                                    }}</span>
                                                </b-card-text>
                                                <b-button
                                                    variant="outline-primary"
                                                    @click="edit(artist)"
                                                >
                                                    Edit
                                                </b-button>
                                                <b-button
                                                    variant="outline-danger"
                                                    @click="remove(artist)"
                                                >
                                                    Delete
                                                </b-button>
                                            </b-card>
                                        </b-col>
                                    </b-row>
                                </b-card>
                            </b-col>
                        </b-row>
                    </b-tab>

                    <b-tab>
                        <template #title>
                            <span class="d-inline-block d-sm-none">
                                <i class="fas fa-home" />
                            </span>
                            <span class="d-none d-sm-inline-block"
                                >Offer Terms</span
                            >
                        </template>

                        <b-row class="mb-5 offer-terms">
                            <b-col>
                                <div class="tabs">
                                    <button
                                        class="tablink active"
                                        @click="openEvent($event, 'offer')"
                                    >
                                        OFFER
                                    </button>
                                    <button
                                        class="tablink"
                                        @click="openEvent($event, 'logistics')"
                                    >
                                        LOGISTICS
                                    </button>
                                    <button
                                        class="tablink"
                                        @click="
                                            openEvent($event, 'artist_expenses')
                                        "
                                    >
                                        ARTIST EXPENSES
                                    </button>
                                    <button
                                        class="tablink"
                                        @click="openEvent($event, 'tickets')"
                                    >
                                        TICKETS
                                    </button>
                                    <button
                                        class="tablink"
                                        @click="
                                            openEvent($event, 'buyer_expenses')
                                        "
                                    >
                                        BUYER EXPENSES
                                    </button>
                                </div>

                                <div
                                    id="offer"
                                    class="tabcontent"
                                    style="display: block"
                                >
                                    <div class="subtab">
                                        <button
                                            class="sublink sub-active"
                                            @click="
                                                openSub($event, 'flat_gurantee')
                                            "
                                        >
                                            FLAT GURANTEE
                                        </button>
                                        <button
                                            class="sublink"
                                            @click="openSub($event, 'versus')"
                                        >
                                            VERSUS
                                        </button>
                                        <button
                                            class="sublink"
                                            @click="
                                                openSub($event, 'plus_bonus')
                                            "
                                        >
                                            PLUS BONUS
                                        </button>
                                        <button
                                            class="sublink"
                                            @click="
                                                openSub(
                                                    $event,
                                                    'straight_percentage'
                                                )
                                            "
                                        >
                                            STRAIGHT PERCENTAGE
                                        </button>
                                    </div>
                                    <div
                                        id="flat_gurantee"
                                        class="subcontent"
                                        style="display: block"
                                    >
                                        <div class="subcontent-wrapper">
                                            <div class="group">
                                                <input
                                                    id=""
                                                    type="number"
                                                    required
                                                    name="amount"
                                                    value=""
                                                    class="ak-input"
                                                    autocomplete="off"
                                                />
                                                <span class="bar" />
                                                <label>Amount (In USD)</label>
                                            </div>
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Gurantee : </span>
                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="toggle-switch-input-1"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="toggle-switch-input-1"
                                                            class="toggle-switch-label"
                                                        />
                                                        Tax is inclusive
                                                    </label>
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span>
                                                    <input
                                                        type="number"
                                                        value="1000"
                                                        class="simple-input"
                                                        placeholder="in Usd"
                                                    />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Precommission
                                                        Costs/Expenses
                                                    </span>
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span>
                                                    <input
                                                        type="number"
                                                        value="1000"
                                                        class="simple-input"
                                                        placeholder="in Usd"
                                                    />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <input
                                                        type="number"
                                                        value="20"
                                                        class="block-input"
                                                    />% &nbsp;
                                                    <span>Booking Fee </span>
                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="booking_fee-1"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="booking_fee-1"
                                                            class="toggle-switch-label"
                                                        />
                                                        On Top
                                                    </label>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Artist Fee </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Costs </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Additional Bonus
                                                    </span>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Withholdings Group
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="versus" class="subcontent">
                                        <div class="subcontent-wrapper">
                                            <div class="versus-box">
                                                <div class="group">
                                                    <input
                                                        type="number"
                                                        required
                                                        name="amount"
                                                        value=""
                                                        class="ak-input"
                                                        autocomplete="off"
                                                    />
                                                    <span class="bar" />
                                                    <label
                                                        >Amount (In USD)</label
                                                    >
                                                </div>
                                                <span class="vs">V.S</span>
                                                <div
                                                    class="input-box-container"
                                                >
                                                    <input
                                                        type="number"
                                                        class="box-input"
                                                        placeholder="Box Office (%)"
                                                    />
                                                    <div class="type">
                                                        <span>Type : </span>
                                                        <select
                                                            class="box-input"
                                                        >
                                                            <option
                                                                >NBOR</option
                                                            >
                                                        </select>
                                                    </div>
                                                    <span
                                                        >Split Point :
                                                        $555</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Gurantee : </span>
                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="toggle-switch-input-2"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="toggle-switch-input-2"
                                                            class="toggle-switch-label"
                                                        />
                                                        Tax is inclusive
                                                    </label>
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span>
                                                    <input
                                                        type="number"
                                                        value="1000"
                                                        class="simple-input"
                                                        placeholder="in Usd"
                                                    />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Precommission
                                                        Costs/Expenses
                                                    </span>
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span>

                                                    <input
                                                        type="number"
                                                        value="1000"
                                                        class="simple-input"
                                                        placeholder="in Usd"
                                                    />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <input
                                                        type="number"
                                                        value="20"
                                                        class="block-input"
                                                    />% &nbsp;
                                                    <span>Booking Fee </span>
                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="booking_fee-2"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="booking_fee-2"
                                                            class="toggle-switch-label"
                                                        />
                                                        On Top
                                                    </label>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Artist Fee </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Costs </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Additional Bonus
                                                    </span>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Withholdings Group
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="plus_bonus" class="subcontent">
                                        <div class="subcontent-wrapper">
                                            <div class="versus-box">
                                                <div class="group">
                                                    <input
                                                        type="number"
                                                        required
                                                        name="amount"
                                                        value=""
                                                        class="ak-input"
                                                        autocomplete="off"
                                                    />
                                                    <span class="bar" />
                                                    <label
                                                        >Amount (In USD)</label
                                                    >
                                                </div>
                                                <span class="vs">PLUS</span>
                                                <div
                                                    class="input-box-container"
                                                >
                                                    <input
                                                        type="number"
                                                        class="box-input"
                                                        placeholder="Box Office (%)"
                                                    />
                                                    <div class="type">
                                                        <span>Type : </span>
                                                        <select
                                                            class="box-input"
                                                        >
                                                            <option
                                                                >NBOR</option
                                                            >
                                                        </select>
                                                    </div>
                                                    <span
                                                        >Split Point :
                                                        $555</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Gurantee : </span>
                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="toggle-switch-input-3"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="toggle-switch-input-3"
                                                            class="toggle-switch-label"
                                                        />
                                                        Tax is inclusive
                                                    </label>
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span>
                                                    <input
                                                        type="number"
                                                        value="1000"
                                                        class="simple-input"
                                                        placeholder="in Usd"
                                                    />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Precommission
                                                        Costs/Expenses
                                                    </span>
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span>

                                                    <input
                                                        type="number"
                                                        value="1000"
                                                        class="simple-input"
                                                        placeholder="in Usd"
                                                    />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <input
                                                        type="number"
                                                        value="20"
                                                        class="block-input"
                                                    />% &nbsp;
                                                    <span>Booking Fee </span>
                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="booking_fee-3"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="booking_fee-3"
                                                            class="toggle-switch-label"
                                                        />
                                                        On Top
                                                    </label>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Artist Fee </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Costs </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Additional Bonus
                                                    </span>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Withholdings Group
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        id="straight_percentage"
                                        class="subcontent"
                                    >
                                        <div class="subcontent-wrapper">
                                            <div class="versus-box">
                                                <div
                                                    class="input-box-container"
                                                >
                                                    <input
                                                        type="number"
                                                        class="box-input"
                                                        placeholder="Box Office (%)"
                                                    />
                                                    <div class="type">
                                                        <span>Type : </span>
                                                        <select
                                                            class="box-input"
                                                        >
                                                            <option
                                                                >NBOR</option
                                                            >
                                                        </select>
                                                    </div>
                                                    <span
                                                        >Split Point :
                                                        $555</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Ticket Bonus : </span>
                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="ticket_bonus"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="ticket_bonus"
                                                            class="toggle-switch-label"
                                                        />
                                                        Tax is inclusive
                                                    </label>

                                                    <label
                                                        class="toggle-switch"
                                                    >
                                                        <input
                                                            id="tickets_final"
                                                            type="checkbox"
                                                            class="toggle-switch-input"
                                                        />
                                                        <label
                                                            for="tickets_final"
                                                            class="toggle-switch-label"
                                                        />
                                                        Tickets Final
                                                    </label>
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span>
                                                    <input
                                                        type="number"
                                                        value="1000"
                                                        class="simple-input"
                                                        placeholder="in Usd"
                                                    />
                                                </div>
                                            </div>
                                            <hr />

                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <input
                                                        type="number"
                                                        value="20"
                                                        class="block-input"
                                                    />% &nbsp;
                                                    <span>Agency Bonus </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span>Artist Bonus </span>
                                                </div>
                                                <div class="total">
                                                    <span>Amount : $</span
                                                    ><span class="value"
                                                        >2400</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Tax : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                                <div class="total">
                                                    <span>Total : $</span
                                                    ><span class="value"
                                                        >0 %</span
                                                    >
                                                </div>
                                            </div>

                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Additional Bonus
                                                    </span>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="option-box">
                                                <div class="align-center">
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        ><img
                                                            src="@/assets/icons/minus.svg"
                                                            class="icon"
                                                    /></span>
                                                    <span
                                                        >Add Withholdings Group
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="logistics" class="tabcontent">
                                    <div class="check-option">
                                        <img
                                            src="@/assets/icons/plane.svg"
                                            class="icon"
                                        />
                                        <label class="toggle-switch">
                                            <input
                                                id="flight"
                                                type="checkbox"
                                                class="toggle-switch-input"
                                            />
                                            <label
                                                for="flight"
                                                class="toggle-switch-label"
                                            />
                                            Purchaser pays for travel.&nbsp;
                                        </label>
                                        <span class="show-link"
                                            >Show Details</span
                                        >
                                    </div>
                                    <div class="check-option">
                                        <img
                                            src="@/assets/icons/truck.svg"
                                            class="icon"
                                        />
                                        <label class="toggle-switch">
                                            <input
                                                id="truck"
                                                type="checkbox"
                                                class="toggle-switch-input"
                                            />
                                            <label
                                                for="truck"
                                                class="toggle-switch-label"
                                            />
                                            Purchaser pays for travel.&nbsp;
                                        </label>
                                        <span class="show-link"
                                            >Show Details</span
                                        >
                                    </div>
                                    <div class="check-option">
                                        <img
                                            src="@/assets/icons/hotel.svg"
                                            class="icon"
                                        />
                                        <label class="toggle-switch">
                                            <input
                                                id="hotel"
                                                type="checkbox"
                                                class="toggle-switch-input"
                                            />
                                            <label
                                                for="hotel"
                                                class="toggle-switch-label"
                                            />
                                            Purchaser pays for travel.&nbsp;
                                        </label>
                                        <span class="show-link"
                                            >Show Details</span
                                        >
                                    </div>
                                    <div class="check-option">
                                        <img
                                            src="@/assets/icons/compass.svg"
                                            class="icon"
                                        />
                                        <label class="toggle-switch">
                                            <input
                                                id="compass"
                                                type="checkbox"
                                                class="toggle-switch-input"
                                            />
                                            <label
                                                for="compass"
                                                class="toggle-switch-label"
                                            />
                                            Purchaser pays for travel.&nbsp;
                                        </label>
                                        <span class="show-link"
                                            >Show Details</span
                                        >
                                    </div>
                                </div>
                                <div id="artist_expenses" class="tabcontent">
                                    <div class="hr" />
                                    <div class="total-bill">
                                        <div class="bill-box">
                                            <span>Total</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Billable</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Paid</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Due</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Not Billed</span>
                                            <span>$100</span>
                                        </div>
                                    </div>
                                    <div class="hr" />
                                    <div class="artist-expenses">
                                        <div class="box-head">
                                            Artist Expenses
                                        </div>
                                        <div class="artist-expense-box">
                                            <div
                                                class="artist-expense-box-container"
                                            >
                                                <div class="box-wrapper">
                                                    <select>
                                                        <option
                                                            >Stage
                                                            Lighting</option
                                                        >
                                                    </select>
                                                    <span>For</span>
                                                    <select>
                                                        <option
                                                            >Bert
                                                            Fountain</option
                                                        >
                                                    </select>
                                                    <div class="add-desc">
                                                        <img
                                                            src="@/assets/icons/plus.svg"
                                                            class="icon-s"
                                                        />
                                                        <span
                                                            >Add
                                                            Description</span
                                                        >
                                                    </div>
                                                </div>
                                                <div class="right-box">
                                                    <input
                                                        type="number"
                                                        class="simple-input w-40"
                                                        value="500"
                                                    />
                                                    <span>Tax</span>
                                                    <input
                                                        type="number"
                                                        class="simple-input"
                                                        value="0"
                                                    />%
                                                </div>
                                            </div>
                                            <div
                                                class="artist-expense-box-container"
                                            >
                                                <div class="box-wrapper">
                                                    <select>
                                                        <option>COST</option>
                                                    </select>
                                                    <span>reimb. to</span>
                                                    <select>
                                                        <option>ITP inc</option>
                                                    </select>
                                                    <div class="add-desc">
                                                        <img
                                                            src="@/assets/icons/close.svg"
                                                            class="icon-s"
                                                        />
                                                        <span>Billable</span>
                                                    </div>
                                                    <div class="add-desc">
                                                        <img
                                                            src="@/assets/icons/tick.svg"
                                                            class="icon-s"
                                                        />
                                                        <span>PreComm</span>
                                                    </div>
                                                </div>
                                                <div class="right-box">
                                                    <span>Total : $</span>
                                                    <input
                                                        type="number"
                                                        class="simple-input"
                                                        value="500"
                                                    />
                                                </div>
                                            </div>
                                            <div class="hr" />
                                        </div>
                                    </div>
                                    <span class="add-desc"
                                        ><img
                                            src="@/assets/icons/plus.svg"
                                            class="icon-s"
                                        />Add Expense</span
                                    >
                                </div>
                                <div id="tickets" class="tabcontent">
                                    <div class="text-hr">Actuals</div>
                                    <div class="total-bill">
                                        <div class="bill-box">
                                            <span>GBOR</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>NBOR</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Ticket Fees</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Split Point</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Bonus Account</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Walk out</span>
                                            <span>$100</span>
                                        </div>
                                    </div>
                                    <div class="hr" />
                                    <div class="table-container">
                                        <div class="table">
                                            <span class="bold-color"
                                                >Ticket Sale</span
                                            >
                                            <span>&nbsp;</span>
                                            <span class="bold-color"
                                                >Tickets</span
                                            >
                                            <span class="bold-color"
                                                >Comps</span
                                            >
                                            <span
                                                style="text-align: end"
                                                class="bold-color"
                                                >Total</span
                                            >
                                            <span
                                                ><img
                                                    src="@/assets/icons/plus.svg"
                                                    class="icon-s"
                                            /></span>
                                        </div>
                                        <div class="table">
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                                placeholder="Description"
                                            />
                                            <span>Planned</span>
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <span style="text-align: end"
                                                >$333</span
                                            >
                                            <img
                                                src="@/assets/icons/close.svg"
                                                class="icon-s"
                                            />
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                                placeholder="Description"
                                            />
                                            <span>Actuals</span>
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <span style="text-align: end"
                                                >$333</span
                                            >
                                        </div>
                                        <div class="table">
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                                placeholder="Description"
                                            />
                                            <span>Planned</span>
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <span style="text-align: end"
                                                >$333</span
                                            >
                                            <img
                                                src="@/assets/icons/close.svg"
                                                class="icon-s"
                                            />
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                                placeholder="Description"
                                            />
                                            <span>Actuals</span>
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <input
                                                type="number"
                                                class="simple-input w-40"
                                            />
                                            <span style="text-align: end"
                                                >$333</span
                                            >
                                        </div>
                                    </div>
                                    <span class="add-desc"
                                        ><img
                                            src="@/assets/icons/plus.svg"
                                            class="icon-s"
                                        />Add Row</span
                                    >
                                    <label class="toggle-switch">
                                        <input
                                            id="toggle-switch-input-4"
                                            type="checkbox"
                                            class="toggle-switch-input"
                                        />
                                        <label
                                            for="toggle-switch-input-4"
                                            class="toggle-switch-label"
                                        />
                                        Ticket Scaling Actuals are final
                                    </label>
                                    <div class="ticket-fees-container mt-2">
                                        <div class="ticket-Fees">
                                            <span>Ticket Fees</span>
                                            <span
                                                style="
                          display: flex;
                          align-items: center;
                          justify-content: flex-end;
                        "
                                                ><img
                                                    src="@/assets/icons/plus.svg"
                                                    class="icon-s"
                                                />Total</span
                                            >
                                        </div>
                                        <div class="ticket-Fees">
                                            <span>No Tickets Added</span>
                                        </div>
                                    </div>
                                    <span class="add-desc"
                                        ><img
                                            src="@/assets/icons/plus.svg"
                                            class="icon-s"
                                        />Add Ticket</span
                                    >
                                </div>
                                <div id="buyer_expenses" class="tabcontent">
                                    <div class="text-hr">Actuals</div>
                                    <div class="total-bill">
                                        <div class="bill-box">
                                            <span>Total</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Fixed</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Variable</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Buyer Commission</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Split Point</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Buyer Profit</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Bonus Amount</span>
                                            <span>$100</span>
                                        </div>
                                        <div class="bill-box">
                                            <span>Walkout</span>
                                            <span>$100</span>
                                        </div>
                                    </div>
                                    <div class="hr" />
                                    <div class="ticket-fees-container mt-2">
                                        <div class="ticket-Fees">
                                            <span>Buyer Expenses</span>
                                            <span
                                                style="
                          display: flex;
                          align-items: center;
                          justify-content: flex-end;
                        "
                                                ><img
                                                    src="@/assets/icons/plus.svg"
                                                    class="icon-s"
                                                />Total</span
                                            >
                                        </div>
                                        <div class="ticket-Fees">
                                            <span>No Buyer Expenses added</span>
                                        </div>
                                    </div>
                                    <span class="add-desc"
                                        ><img
                                            src="@/assets/icons/plus.svg"
                                            class="icon-s"
                                        />Add Expense</span
                                    >
                                    <div class="ticket-fees-container mt-2">
                                        <div class="ticket-Fees">
                                            <span>Buyer Commission</span>
                                            <span
                                                style="
                          display: flex;
                          align-items: center;
                          justify-content: flex-end;
                        "
                                                ><img
                                                    src="@/assets/icons/plus.svg"
                                                    class="icon-s"
                                                />Total</span
                                            >
                                        </div>
                                        <div class="ticket-Fees">
                                            <span>No Buyer Commission</span>
                                        </div>
                                    </div>
                                    <span class="add-desc"
                                        ><img
                                            src="@/assets/icons/plus.svg"
                                            class="icon-s"
                                        />Add Commission</span
                                    >
                                    <div class="align-center">
                                        <label class="toggle-switch">
                                            <input
                                                id="toggle-switch-input-5"
                                                type="checkbox"
                                                class="toggle-switch-input"
                                            />
                                            <label
                                                for="toggle-switch-input-5"
                                                class="toggle-switch-label"
                                            />
                                            Include All Buyer Expenses in Split
                                            Point
                                        </label>
                                        <label class="toggle-switch">
                                            <input
                                                id="toggle-switch-input-6"
                                                type="checkbox"
                                                class="toggle-switch-input"
                                            />
                                            <label
                                                for="toggle-switch-input-6"
                                                class="toggle-switch-label"
                                            />
                                            Include Gurantee in Split Point
                                        </label>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                    </b-tab>
                </b-tabs>
            </b-col>
        </b-row>

        <b-modal
            v-model="modal.show"
            :title="modal.title"
            title-class="text-black font-18"
            body-class="p-3"
            hide-footer
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-header-close="true"
        >
            <b-form @submit.prevent="handle">
                <b-row>
                    <b-col>
                        <b-form-group label="Name" label-for="artist_name">
                            <multiselect
                                id="artist_name"
                                v-model="form.id"
                                :options="filteredArtists"
                                :loading="isSearching"
                                :limit="10"
                                :internal-search="false"
                                :max-height="400"
                                :clear-on-select="true"
                                :close-on-select="true"
                                :searchable="true"
                                track-by="value"
                                label="label"
                                @search-change="search"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.stages_time_slots.length > 0">
                    <b-col cols="12">
                        <h6>Selected Stages:</h6>
                    </b-col>
                    <b-col
                        v-for="(val, idx) in form.stages_time_slots"
                        :key="idx"
                        cols="12"
                    >
                        <p v-if="val.slots.length > 0">
                            {{ val.stage.name }}:
                            <br />
                            <span
                                v-for="(slot, index) in val.slots"
                                :key="index"
                            >
                                {{ formatDate(slot.time.start, "hh:mm A") }} -
                                {{ formatDate(slot.time.end, "hh:mm A") }} |
                                {{ fetchStatus(slot.status, "value") }} -
                                {{
                                    fetchHoldPosition(
                                        slot.hold_position,
                                        "value"
                                    )
                                }}
                                <br v-if="index + 1 < val.slots.length" />
                            </span>
                        </p>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label-for="talent_stage" label="Stages">
                            <b-form-select
                                v-model="selectedStage"
                                :options="stages"
                                @change="showTimeSlotsForStage()"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="selectedStage !== null">
                    <b-col>
                        <b-form-group label="Time Slots:">
                            <b-form-checkbox-group
                                id="checkbox-group-1"
                                v-model="selectedTimeSlots"
                                name="time_slots"
                                @change.native="updateTimeSlotsForStage"
                            >
                                <b-form-checkbox value="flavour" class="mb-5">
                                    Test
                                </b-form-checkbox>
                                <b-v-form-btn-label-control />
                            </b-form-checkbox-group>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label-for="talent_amount" label="Amount">
                            <b-form-input
                                id="talent_amount"
                                v-model.number="form.amount"
                                class="col-3"
                                placeholder="0"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group
                            label="Promoter Profit"
                            label-for="promoter_profit_enable"
                        >
                            <switches
                                id="promoter_profit_enable"
                                v-model="form.promoter_profit_enable"
                                type-bold="false"
                                color="info"
                                class="mt-1"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.promoter_profit_enable">
                    <b-col>
                        <b-form-group
                            label-for="promoter_profit"
                            label="Profit"
                        >
                            <b-form-input
                                id="promoter_profit"
                                v-model.number="form.promoter_profit"
                                class="col-3"
                                placeholder="0%"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.status === 10 || form.status === 11">
                    <b-col>
                        <b-form-group
                            label-for="cancellation_terms"
                            label="Cancellation Terms"
                        >
                            <b-form-textarea
                                id="cancellation_terms"
                                v-model="form.cancellation_terms"
                                class=""
                                placeholder="Ex: deposit, full refund or partial refund and Artist and Venue will reconsider Mutually Agreeable Date for 2022-2023"
                                rows="3"
                                max-rows="6"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.status === 5">
                    <b-col>
                        <h5 style="padding: 5px 0; background-color: yellow">
                            {{ firstHoldArtistName }}
                        </h5>
                    </b-col>
                </b-row>

                <b-row v-if="form.status === 12">
                    <b-col>
                        <h5 style="padding: 5px 0; background-color: yellow">
                            {{ secondHoldArtistName }}
                        </h5>
                    </b-col>
                </b-row>

                <b-row v-if="form.type !== 'historical'">
                    <b-col>
                        <b-form-group
                            label="Talent type"
                            label-for="artist_type"
                        >
                            <b-form-radio
                                v-model="form.type"
                                name="artist_type"
                                value="headliner"
                            >
                                Headliner
                            </b-form-radio>
                            <b-form-radio
                                v-model="form.type"
                                name="artist_type"
                                value="support"
                                class="ml-3"
                            >
                                Support
                            </b-form-radio>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.status === 3 || form.status === 9">
                    <b-col>
                        <label v-if="form.status === 3"
                            >Mutually Agreed Date Note</label
                        >
                        <label v-else>Reason</label>
                        <b-form-group label-for="date_notes">
                            <b-form-textarea
                                id="date_notes"
                                v-model="form.date_notes"
                                class=""
                                placeholder="Enter something..."
                                rows="3"
                                max-rows="6"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.status === 5">
                    <b-col>
                        <b-form-group
                            label-for="challenged_hours"
                            label="Hours Challenged Hold Expires In (like: 24,48,72)"
                        >
                            <b-form-input
                                id="challenged_hours"
                                v-model.number="form.challenged_hours"
                                type="number"
                                class="col-3"
                                placeholder="0"
                                min="0"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="form.status === 7">
                    <b-col>
                        <b-form-group
                            label-for="offer_expiration_time"
                            label="Offer Expires In (like: 24,48,72)"
                        >
                            <b-form-input
                                id="offer_expiration_time"
                                v-model.number="form.offer_expiration_time"
                                type="number"
                                class="col-3"
                                placeholder="24"
                                min="0"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="representativeData.dates.length > 0">
                    <b-col>
                        <h6>
                            Explore Mutually Agreeable Dates for Future
                            Consideration
                        </h6>
                    </b-col>
                </b-row>
                <b-row v-if="representativeData.dates.length > 0">
                    <b-col>
                        <b-table
                            :fields="representativeDataFields"
                            :items="representativeData.dates"
                        />
                    </b-col>
                </b-row>

                <b-row v-if="representativeData.notes">
                    <b-col>
                        <p>
                            <strong>Artist Representative Notes:- </strong
                            >{{ representativeData.notes }}
                        </p>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col>
                        <b-form-group label-for="notes" label="Notes">
                            <b-form-textarea
                                id="notes"
                                v-model="form.notes"
                                class=""
                                placeholder="Enter something..."
                                rows="3"
                                max-rows="6"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <!-- Agency, management, publicity html -->
                <b-row>
                    <b-col>
                        <b-form-group>
                            <b-radio-group v-model="selectedRadio">
                                <b-form-radio value="agency">
                                    Agency Details
                                </b-form-radio>
                                <b-form-radio value="management">
                                    Management Details
                                </b-form-radio>
                                <b-form-radio value="publicity">
                                    Publicity Details
                                </b-form-radio>
                            </b-radio-group>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="selectedRadio === 'agency'">
                    <b-col cols="12">
                        <b-form-group
                            label-for="agency_name"
                            label="Agency Name:"
                        >
                            <b-form-input
                                id="agency_name"
                                v-model="form.agency.name"
                                placeholder="Enter Agency Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="agent_name"
                            label="Agent Name:"
                        >
                            <b-form-input
                                id="agent_name"
                                v-model="form.agency.agent_name"
                                placeholder="Enter Agent Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="agent_phone">
                            <template slot="label">
                                Agent Phone:
                                <a
                                    v-if="form.agency.agent_phone"
                                    :href="'tel:' + form.agency.agent_phone"
                                    ><i class="fa fa-phone"
                                /></a>
                            </template>
                            <b-form-input
                                id="agent_phone"
                                v-model="form.agency.agent_phone"
                                placeholder="Enter Agent Phone"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="agent_email">
                            <template slot="label">
                                Agent Email:
                                <a
                                    v-if="form.agency.agent_email"
                                    :href="'mailto:' + form.agency.agent_email"
                                    ><i class="fa fa-envelope"
                                /></a>
                            </template>
                            <b-form-input
                                id="agent_email"
                                v-model="form.agency.agent_email"
                                placeholder="Enter Agent Email"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="agent_assistant_name"
                            label="Agent Assistant Name:"
                        >
                            <b-form-input
                                id="agent_assistant_name"
                                v-model="form.agency.agent_assistant_name"
                                placeholder="Enter Agent Assistant Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="agent_assistant_phone">
                            <template slot="label">
                                Agent Assistant Phone:
                                <a
                                    v-if="form.agency.agent_assistant_phone"
                                    :href="
                                        'tel:' +
                                            form.agency.agent_assistant_phone
                                    "
                                    ><i class="fa fa-phone"
                                /></a>
                            </template>
                            <b-form-input
                                id="agent_assistant_phone"
                                v-model="form.agency.agent_assistant_phone"
                                placeholder="Enter Agent Assistant Phone"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="selectedRadio === 'management'">
                    <b-col cols="12">
                        <b-form-group
                            label-for="management_firm_name"
                            label="Management Firm Name:"
                        >
                            <b-form-input
                                id="management_firm_name"
                                v-model="form.management_firm.name"
                                placeholder="Enter Management Firm Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="manager_name"
                            label="Manager Name:"
                        >
                            <b-form-input
                                id="manager_name"
                                v-model="form.management_firm.manager_name"
                                placeholder="Enter Manager Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="manager_phone">
                            <template slot="label">
                                Manager Phone:
                                <a
                                    v-if="form.management_firm.manager_phone"
                                    :href="
                                        'tel:' +
                                            form.management_firm.manager_phone
                                    "
                                    ><i class="fa fa-phone"
                                /></a>
                            </template>
                            <b-form-input
                                id="manager_phone"
                                v-model="form.management_firm.manager_phone"
                                placeholder="Enter Manager Phone"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="manager_email">
                            <template slot="label">
                                Manager Email:
                                <a
                                    v-if="form.management_firm.manager_email"
                                    :href="
                                        'mailto:' +
                                            form.management_firm.manager_email
                                    "
                                    ><i class="fa fa-envelope"
                                /></a>
                            </template>
                            <b-form-input
                                id="manager_email"
                                v-model="form.management_firm.manager_email"
                                placeholder="Enter Manager Email"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="manager_assistant_name"
                            label="Manager Assistant Name:"
                        >
                            <b-form-input
                                id="manager_assistant_name"
                                v-model="
                                    form.management_firm.manager_assistant_name
                                "
                                placeholder="Enter Manager Assistant Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="manager_assistant_phone">
                            <template slot="label">
                                Manager Assistant Phone:
                                <a
                                    v-if="
                                        form.management_firm
                                            .manager_assistant_phone
                                    "
                                    :href="
                                        'tel:' +
                                            form.management_firm
                                                .manager_assistant_phone
                                    "
                                    ><i class="fa fa-phone"
                                /></a>
                            </template>
                            <b-form-input
                                id="manager_assistant_phone"
                                v-model="
                                    form.management_firm.manager_assistant_phone
                                "
                                placeholder="Enter Manager Assistant Phone"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="manager_assistant_email">
                            <template slot="label">
                                Manager Assistant Email:
                                <a
                                    v-if="
                                        form.management_firm
                                            .manager_assistant_email
                                    "
                                    :href="
                                        'mailto:' +
                                            form.management_firm
                                                .manager_assistant_email
                                    "
                                    ><i class="fa fa-envelope"
                                /></a>
                            </template>
                            <b-form-input
                                id="manager_assistant_email"
                                v-model="
                                    form.management_firm.manager_assistant_email
                                "
                                placeholder="Enter Manager Assistant Email"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row v-if="selectedRadio === 'publicity'">
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicity_firm_name"
                            label="Publicity Firm Name:"
                        >
                            <b-form-input
                                id="publicity_firm_name"
                                v-model="form.publicity_firm.name"
                                placeholder="Enter Publicity Firm Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_name"
                            label="Publicist Name:"
                        >
                            <b-form-input
                                id="publicist_name"
                                v-model="form.publicity_firm.publicist_name"
                                placeholder="Enter Publicist Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="publicist_phone">
                            <template slot="label">
                                Publicist Phone:
                                <a
                                    v-if="form.publicity_firm.publicist_phone"
                                    :href="
                                        'tel:' +
                                            form.publicity_firm.publicist_phone
                                    "
                                    ><i class="fa fa-phone"
                                /></a>
                            </template>
                            <b-form-input
                                id="publicist_phone"
                                v-model="form.publicity_firm.publicist_phone"
                                placeholder="Enter Publicist Phone"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="publicist_email">
                            <template slot="label">
                                Publicist Email:
                                <a
                                    v-if="form.publicity_firm.publicist_email"
                                    :href="
                                        'mailto:' +
                                            form.publicity_firm.publicist_email
                                    "
                                    ><i class="fa fa-envelope"
                                /></a>
                            </template>
                            <b-form-input
                                id="publicist_email"
                                v-model="form.publicity_firm.publicist_email"
                                placeholder="Enter Publicist Email"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_assistant_name"
                            label="Publicist Assistant Name:"
                        >
                            <b-form-input
                                id="publicist_assistant_name"
                                v-model="
                                    form.publicity_firm.publicist_assistant_name
                                "
                                placeholder="Enter Publicist Assistant Name"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="publicist_assistant_phone">
                            <template slot="label">
                                Publicist Assistant Phone:
                                <a
                                    v-if="
                                        form.publicity_firm
                                            .publicist_assistant_phone
                                    "
                                    :href="
                                        'tel:' +
                                            form.publicity_firm
                                                .publicist_assistant_phone
                                    "
                                    ><i class="fa fa-phone"
                                /></a>
                            </template>
                            <b-form-input
                                id="publicist_assistant_phone"
                                v-model="
                                    form.publicity_firm
                                        .publicist_assistant_phone
                                "
                                placeholder="Enter Publicist Assistant Phone"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group label-for="publicist_assistant_email">
                            <template slot="label">
                                Publicist Assistant Email:
                                <a
                                    v-if="
                                        form.publicity_firm
                                            .publicist_assistant_email
                                    "
                                    :href="
                                        'mailto:' +
                                            form.publicity_firm
                                                .publicist_assistant_email
                                    "
                                    ><i class="fa fa-envelope"
                                /></a>
                            </template>
                            <b-form-input
                                id="publicist_assistant_email"
                                v-model="
                                    form.publicity_firm
                                        .publicist_assistant_email
                                "
                                placeholder="Enter Publicist Assistant Email"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicity_doc"
                            label="Upload Doc:"
                        >
                            <b-form-file
                                id="publicity_doc"
                                placeholder="Upload Doc"
                            />
                        </b-form-group>
                    </b-col>

                    <!-- Social Links -->
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_facebook"
                            label="Facebook:"
                        >
                            <b-form-input
                                id="publicist_facebook"
                                v-model="form.publicity_firm.facebook"
                                placeholder="Enter Facebook Link"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_twitter"
                            label="Twitter:"
                        >
                            <b-form-input
                                id="publicist_twitter"
                                v-model="form.publicity_firm.twitter"
                                placeholder="Enter Twitter Link"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_instagram"
                            label="Instagram:"
                        >
                            <b-form-input
                                id="publicist_instagram"
                                v-model="form.publicity_firm.instagram"
                                placeholder="Enter Instagram Link"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_website"
                            label="Website:"
                        >
                            <b-form-input
                                id="publicist_website"
                                v-model="form.publicity_firm.website"
                                placeholder="Enter Website Link"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_apple_music"
                            label="Apple Music:"
                        >
                            <b-form-input
                                id="publicist_apple_music"
                                v-model="form.publicity_firm.apple_music"
                                placeholder="Enter Apple Music Link"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_spotify"
                            label="Spotify:"
                        >
                            <b-form-input
                                id="publicist_spotify"
                                v-model="form.publicity_firm.spotify"
                                placeholder="Enter Spotify Link"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="12">
                        <b-form-group
                            label-for="publicist_sound_cloud"
                            label="Description:"
                        >
                            <b-form-textarea
                                id="publicist_sound_cloud"
                                v-model="form.publicity_firm.sound_cloud"
                                placeholder="Enter Description"
                                rows="5"
                            />
                        </b-form-group>
                    </b-col>
                    <!-- Social Links -->
                </b-row>
                <!-- Agency, management, publicity html -->

                <b-row class="mb-5">
                    <b-col>
                        <b-button
                            variant="outline-secondary float-right ml-2"
                            @click="cancel"
                        >
                            Cancel
                        </b-button>
                        <b-button
                            variant="outline-info float-right"
                            type="submit"
                        >
                            Submit
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </b-modal>

        <b-modal
            v-model="showStatusModal"
            :title="'Update Status and hold position'"
            title-class="text-black font-18"
            body-class="p-3"
            hide-footer
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-header-close="true"
        >
            <b-row>
                <b-col>
                    <b-form-group label="Status" label-for="artist_status">
                        <b-form-select
                            v-model="statusForm.status"
                            :options="statuses"
                            @input="
                                setChallengeData();
                                setHoldPositions(form.status);
                            "
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-form-group
                        label="Hold Position"
                        label-for="artist_hold_position"
                    >
                        <b-form-select
                            v-model="statusForm.hold_position"
                            :options="holdPositions"
                            :disabled="[5, 6].includes(form.status)"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row class="mb-5">
                <b-col>
                    <b-button
                        variant="outline-secondary float-right ml-2"
                        @click="cancelStatusModal"
                    >
                        Cancel
                    </b-button>
                    <b-button
                        variant="outline-info float-right"
                        @click="saveStatus"
                    >
                        Submit
                    </b-button>
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>

<script>
import { cloneDeep } from "lodash";
import VueCountdownTimer from "vuejs-countdown-timer";
import Multiselect from "vue-multiselect";
import Switches from "vue-switches";
import Vue from "vue";
import moment from "moment";
import BVFormBtnLabelControl from "../../../../../../public/js/app";
Vue.use(VueCountdownTimer);

export default {
    name: "TalentTab",
    components: { BVFormBtnLabelControl, Multiselect, Switches },
    props: {
        event: {
            type: Object,
            default() {
                return {};
            },
            required: true,
        },
    },
    data() {
        return {
            artists: [],
            filteredArtists: [],
            isSearching: false,
            statuses: [],
            rawStatuses: [],
            holdPositions: [],
            rawHoldPositions: [],
            assignedHoldPositions: [],
            statusColor: [],
            holdPositionColor: [],
            modal: this.default("modal"),
            form: this.default("form"),
            selectedRadio: "agency",
            representativeDataFields: [
                {
                    key: "month",
                    label: "Month",
                },
                {
                    key: "day",
                    label: "Day of Week",
                },
                {
                    key: "year",
                    label: "Year",
                },
            ],
            representativeData: {
                notes: "",
                dates: [],
            },
            initiated: false,
            challengeData: {
                to: {
                    name: "",
                    id: "",
                },
                by: {
                    name: "",
                    id: "",
                },
                hours: null,
                timestamp: null,
            },
            stages: [],
            rawTimeSlots: [],
            timeSlots: [],
            selectedStage: null,
            selectedTimeSlots: [],
            activities: {},
            showStatusModal: false,
            statusForm: this.default("statusForm"),
            popover: {
                target: "",
                show: false,
                artist: {},
            },
        };
    },
    computed: {
        headliners: function() {
            return this.artists
                .filter(function(artist) {
                    return artist.type === "headliner";
                })
                .sort(function(a, b) {
                    return a.hold_position_order - b.hold_position_order;
                });
        },
        supports: function() {
            return this.artists
                .filter(function(artist) {
                    return artist.type === "support";
                })
                .sort(function(a, b) {
                    return a.hold_position_order - b.hold_position_order;
                });
        },
        historical: function() {
            return this.artists
                .filter(function(artist) {
                    return artist.type === "historical";
                })
                .sort(function(a, b) {
                    return a.hold_position_order - b.hold_position_order;
                });
        },
        firstHoldArtistName: function() {
            let name = "";
            for (let i = 0; i < this.artists.length; i++) {
                if (
                    this.fetchHoldPosition(
                        this.artists[i].hold_position,
                        "key"
                    ) === 2
                ) {
                    name = this.artists[i].name;
                    break;
                }
            }
            return name;
        },
        secondHoldArtistName: function() {
            let name = "";
            for (let i = 0; i < this.artists.length; i++) {
                if (
                    this.fetchHoldPosition(
                        this.artists[i].hold_position,
                        "key"
                    ) === 3
                ) {
                    name = this.artists[i].name;
                    break;
                }
            }
            return name;
        },
        talentSummary: function() {
            let summary = [];
            let activities = cloneDeep(this.activities.stage) || [];

            for (let i = 0; i < activities.length; i++) {
                let flag = true;

                for (let j = 0; j < summary.length; j++) {
                    if (activities[i].stage.id === summary[j].id) {
                        let isTimePresent = false;
                        for (let k = 0; k < summary[j].slots.length; k++) {
                            if (
                                summary[j].slots[k].time ===
                                this.utcTimestamp(activities[i].start) +
                                    "," +
                                    this.utcTimestamp(activities[i].end)
                            ) {
                                let isArtistPresent = false;
                                for (
                                    let l = 0;
                                    l < summary[j].slots[k].artists.length;
                                    l++
                                ) {
                                    if (
                                        summary[j].slots[k].artists[l].id ===
                                        activities[i].artist_id
                                    ) {
                                        isArtistPresent = true;
                                        break;
                                    }
                                }
                                if (isArtistPresent === false) {
                                    let tempArtist = {};
                                    for (
                                        let l = 0;
                                        l < this.artists.length;
                                        l++
                                    ) {
                                        if (
                                            this.artists[l].id ===
                                            activities[i].artist_id
                                        ) {
                                            let tempArtistStatus = null,
                                                tempArtistHoldPosition = null;

                                            for (
                                                let m = 0;
                                                m <
                                                this.artists[l].my_activities
                                                    .length;
                                                m++
                                            ) {
                                                if (
                                                    this.artists[l]
                                                        .my_activities[m].stage
                                                        .id ===
                                                    activities[i].stage.id
                                                ) {
                                                    for (
                                                        let n = 0;
                                                        n <
                                                        this.artists[l]
                                                            .my_activities[m]
                                                            .slots.length;
                                                        n++
                                                    ) {
                                                        let tempTimeStr =
                                                            this.artists[l]
                                                                .my_activities[
                                                                m
                                                            ].slots[n].time
                                                                .start +
                                                            "," +
                                                            this.artists[l]
                                                                .my_activities[
                                                                m
                                                            ].slots[n].time.end;
                                                        if (
                                                            tempTimeStr ===
                                                            this.utcTimestamp(
                                                                activities[i]
                                                                    .start
                                                            ) +
                                                                "," +
                                                                this.utcTimestamp(
                                                                    activities[
                                                                        i
                                                                    ].end
                                                                )
                                                        ) {
                                                            tempArtistStatus = this.fetchStatus(
                                                                this.artists[l]
                                                                    .my_activities[
                                                                    m
                                                                ].slots[n]
                                                                    .status,
                                                                "value"
                                                            );
                                                            tempArtistHoldPosition = this.fetchHoldPosition(
                                                                this.artists[l]
                                                                    .my_activities[
                                                                    m
                                                                ].slots[n]
                                                                    .hold_position,
                                                                "value"
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                            tempArtist = cloneDeep({
                                                ...this.artists[l],
                                                status: tempArtistStatus,
                                                hold_position: tempArtistHoldPosition,
                                            });
                                        }
                                    }
                                    summary[j].slots[k].artists.push(
                                        tempArtist
                                    );
                                }
                                isTimePresent = true;
                                break;
                            }
                        }

                        if (isTimePresent === false) {
                            let tempArtistList = [];
                            for (let k = 0; k < this.artists.length; k++) {
                                if (
                                    this.artists[k].id ===
                                    activities[i].artist_id
                                ) {
                                    let tempArtistStatus = null,
                                        tempArtistHoldPosition = null;

                                    for (
                                        let l = 0;
                                        l <
                                        this.artists[k].my_activities.length;
                                        l++
                                    ) {
                                        if (
                                            this.artists[k].my_activities[l]
                                                .stage.id ===
                                            activities[i].stage.id
                                        ) {
                                            for (
                                                let m = 0;
                                                m <
                                                this.artists[k].my_activities[l]
                                                    .slots.length;
                                                m++
                                            ) {
                                                let tempTimeStr =
                                                    this.artists[k]
                                                        .my_activities[l].slots[
                                                        m
                                                    ].time.start +
                                                    "," +
                                                    this.artists[k]
                                                        .my_activities[l].slots[
                                                        m
                                                    ].time.end;
                                                if (
                                                    tempTimeStr ===
                                                    this.utcTimestamp(
                                                        activities[i].start
                                                    ) +
                                                        "," +
                                                        this.utcTimestamp(
                                                            activities[i].end
                                                        )
                                                ) {
                                                    tempArtistStatus = this.fetchStatus(
                                                        this.artists[k]
                                                            .my_activities[l]
                                                            .slots[m].status,
                                                        "value"
                                                    );
                                                    tempArtistHoldPosition = this.fetchHoldPosition(
                                                        this.artists[k]
                                                            .my_activities[l]
                                                            .slots[m]
                                                            .hold_position,
                                                        "value"
                                                    );
                                                }
                                            }
                                        }
                                    }
                                    tempArtistList.push(
                                        cloneDeep({
                                            ...this.artists[k],
                                            status: tempArtistStatus,
                                            hold_position: tempArtistHoldPosition,
                                        })
                                    );
                                }
                            }

                            summary[j].slots.push({
                                time:
                                    this.utcTimestamp(activities[i].start) +
                                    "," +
                                    this.utcTimestamp(activities[i].end),
                                formatted:
                                    this.anotherFormat(
                                        activities[i].start,
                                        "HH:mm"
                                    ) +
                                    "-" +
                                    this.anotherFormat(
                                        activities[i].end,
                                        "HH:mm"
                                    ),
                                artists: tempArtistList,
                            });
                        }

                        flag = false;
                        break;
                    }
                }

                if (flag === true) {
                    let tempArtistList = [];
                    for (let j = 0; j < this.artists.length; j++) {
                        if (this.artists[j].id === activities[i].artist_id) {
                            let tempArtistStatus = null,
                                tempArtistHoldPosition = null;

                            for (
                                let k = 0;
                                k < this.artists[j].my_activities.length;
                                k++
                            ) {
                                if (
                                    this.artists[j].my_activities[k].stage
                                        .id === activities[i].stage.id
                                ) {
                                    for (
                                        let l = 0;
                                        l <
                                        this.artists[j].my_activities[k].slots
                                            .length;
                                        l++
                                    ) {
                                        let tempTimeStr =
                                            this.artists[j].my_activities[k]
                                                .slots[l].time.start +
                                            "," +
                                            this.artists[j].my_activities[k]
                                                .slots[l].time.end;
                                        if (
                                            tempTimeStr ===
                                            this.utcTimestamp(
                                                activities[i].start
                                            ) +
                                                "," +
                                                this.utcTimestamp(
                                                    activities[i].end
                                                )
                                        ) {
                                            tempArtistStatus = this.fetchStatus(
                                                this.artists[j].my_activities[k]
                                                    .slots[l].status,
                                                "value"
                                            );
                                            tempArtistHoldPosition = this.fetchHoldPosition(
                                                this.artists[j].my_activities[k]
                                                    .slots[l].hold_position,
                                                "value"
                                            );
                                        }
                                    }
                                }
                            }
                            tempArtistList.push(
                                cloneDeep({
                                    ...this.artists[j],
                                    status: tempArtistStatus,
                                    hold_position: tempArtistHoldPosition,
                                })
                            );
                        }
                    }

                    summary.push({
                        ...activities[i].stage,
                        slots: [
                            {
                                time:
                                    this.utcTimestamp(activities[i].start) +
                                    "," +
                                    this.utcTimestamp(activities[i].end),
                                formatted:
                                    this.anotherFormat(
                                        activities[i].start,
                                        "HH:mm"
                                    ) +
                                    "-" +
                                    this.anotherFormat(
                                        activities[i].end,
                                        "HH:mm"
                                    ),
                                artists: tempArtistList,
                            },
                        ],
                    });
                }
            }

            return summary;
        },
        talentHistory: function() {
            let setHistory = [];
            this.talentSummary.forEach((talent, talentIndex) => {
                // if (talentSummaryId === talent.id) {
                    for (let i = 0; i < talent.slots.length; i++) {
                        for (
                            let j = 0;
                            j < talent.slots[i].artists.length;
                            j++
                        ) {
                            let time = talent.slots[i].time.split(",");
                            let startTime = Number(time[0]);
                            let endTime = Number(time[1]);
                            setHistory.push({
                                artistName: talent.slots[i].artists[j].name,
                                notes: talent.slots[i].artists[j].notes,
                                hold_position:
                                    talent.slots[i].artists[j].hold_position,
                                notes: talent.slots[i].artists[j].notes,
                                status: talent.slots[i].artists[j].status,
                                // talentSummaryId: talent.id,
                                stage_name: talent.name,
                                price: talent.slots[i].artists[j].amount,
                                offer_term: "Offer",
                                notes: talent.slots[i].artists[j].notes,
                                startTime: startTime,
                                endTime: endTime,
                            });
                        }
                    }
                // }
            });
            return setHistory;
        }
    },
    watch: {
        event: {
            handler: function() {
                if (this.initiated) {
                    this.setData();
                }
            },
            deep: true,
        },
    },
    created() {
        this.$http
            .get("events/" + this.$route.params.id + "/artists/create")
            .then((response) => {
                if (
                    Object.prototype.hasOwnProperty.call(
                        response.data.data,
                        "statuses"
                    )
                ) {
                    this.rawStatuses = cloneDeep(response.data.data.statuses);
                }

                if (
                    Object.prototype.hasOwnProperty.call(
                        response.data.data,
                        "hold_positions"
                    )
                ) {
                    this.rawHoldPositions = cloneDeep(
                        response.data.data.hold_positions
                    );
                }

                if (
                    Object.prototype.hasOwnProperty.call(
                        response.data.data,
                        "status_colors"
                    )
                ) {
                    this.statusColor = response.data.data.status_colors;
                }

                if (
                    Object.prototype.hasOwnProperty.call(
                        response.data.data,
                        "hold_positions_colors"
                    )
                ) {
                    this.holdPositionColor =
                        response.data.data.hold_positions_colors;
                }
            })
            .catch((error) => {
                this.$toastr.fire({
                    toast: true,
                    icon: "error",
                    title: error.response.data.message,
                });
            })
            .then(() => {
                this.initiated = true;
                this.setData();
            });
    },
    methods: {
        setData() {
            if (Object.prototype.hasOwnProperty.call(this.event, "artists")) {
                this.artists = cloneDeep(this.event.artists);
            }

            this.stages = [
                {
                    text: "Select Stage",
                    value: null,
                },
            ];
            if (Object.prototype.hasOwnProperty.call(this.event, "stages")) {
                for (let i = 0; i < this.event.stages.length; i++) {
                    this.stages.push({
                        text: this.event.stages[i].name,
                        value: this.event.stages[i].id,
                    });
                }
            }

            this.rawTimeSlots = [];
            if (
                Object.prototype.hasOwnProperty.call(this.event, "time_slots")
            ) {
                for (let i = 0; i < this.event.time_slots.length; i++) {
                    this.rawTimeSlots.push({
                        text:
                            moment
                                .utc(this.event.time_slots[i][0])
                                .local()
                                .format("hh:mm A") +
                            " - " +
                            moment
                                .utc(this.event.time_slots[i][1])
                                .local()
                                .format("hh:mm A"),
                        value:
                            this.event.time_slots[i][0] +
                            "," +
                            this.event.time_slots[i][1],
                    });
                }
            }

            if (
                Object.prototype.hasOwnProperty.call(this.event, "activities")
            ) {
                this.activities = cloneDeep(this.event.activities);
            }
        },
        add() {
            this.modal.show = true;
            this.modal.title = "Add Artist";
            this.modal.add = true;
            this.setStatuses();
            this.setAssignedHoldPositions();
            this.setHoldPositions();
        },
        edit(info) {
            this.modal.show = true;
            this.modal.title = "Edit Artist";
            this.modal.edit = true;

            this.form.id = { label: info.name, value: info.id };
            this.form.type = info.type;
            this.form.promoter_profit_enable = Number(info.promoter_profit) > 0;
            this.form.promoter_profit = Number(info.promoter_profit);
            this.form.status = this.fetchStatus(info.status, "key");
            this.form.date_notes = info.date_notes;
            if (info.challenged) {
                this.form.challenged_by = info.challenged.by;
                this.form.challenged_hours = info.challenged.hours;
            }
            this.form.hold_position = this.fetchHoldPosition(
                info.hold_position,
                "key"
            );
            this.form.notes = info.notes;
            this.form.amount = info.amount;

            this.form.agency = cloneDeep(info.agency);
            this.form.management_firm = cloneDeep(info.management_firm);
            this.form.publicity_firm = cloneDeep(info.publicity_firm);

            this.representativeData = cloneDeep(info.artist_representative_mad);

            this.form.cancellation_terms = info.cancellation_terms;
            this.form.stages_time_slots = cloneDeep(info.my_activities);
            this.setStatuses();
            this.setAssignedHoldPositions();
            this.setHoldPositions(this.form.status);
        },
        remove(info) {
            this.form.id = info.id;
            this.modal.delete = true;
            this.$swal
                .fire({
                    text: "You want to delete this artist?",
                    confirmButtonText: "Delete",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.handle();
                    }
                });
        },
        search(name) {
            if (name.length >= 3) {
                this.isSearching = true;
                this.$http
                    .get(
                        "artists?filter=" +
                            name +
                            "&per-page=10&event=" +
                            this.event.id
                    )
                    .then((response) => {
                        this.filteredArtists = [];
                        for (
                            let i = 0;
                            i < response.data.data.data.length;
                            i++
                        ) {
                            this.filteredArtists.push({
                                label: response.data.data.data[i].name,
                                value: response.data.data.data[i].id,
                                image: response.data.data.data[i].image_url,
                            });
                        }
                        this.isSearching = false;
                    })
                    .catch((error) => {
                        this.$toastr.fire({
                            icon: "error",
                            title: error.response.data.message,
                        });
                    });
            }
        },
        cancel() {
            this.filteredArtists = [];
            this.modal = this.default("modal");
            this.form = this.default("form");
            this.statusForm = this.default("statusForm");
            this.representativeData = cloneDeep({
                notes: "",
                dates: [],
            });
            this.selectedStage = null;
            this.selectedTimeSlots = [];
        },
        handle() {
            let params = {
                title: "",
                text:
                    "You have changed the Status and/or the artist's Hold position. Do you want to send an email to update the artist's representative?",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            };
            if (this.form.status === 11) {
                params = {
                    icon: "info",
                    showCancelButton: false,
                    title: "",
                    text:
                        "This status is for emergency purposes only such as event cancellation, postponement, facility disasters, artist sickness or unforeseen circumstances. A custom email needs to be drafted.",
                    confirmButtonText: "Okay",
                };
            }

            this.$swal.fire(params).then((result) => {
                this.save(result.isConfirmed);
            });
        },
        default(type) {
            let result = {};
            switch (type) {
                case "form":
                    result = {
                        id: "",
                        type: "headliner",
                        promoter_profit_enable: false,
                        promoter_profit: 0,
                        date_notes: "",
                        challenged_by: "",
                        challenged_hours: 0,
                        amount: 0,
                        offer_expiration_time: 0,
                        agency: {
                            name: "",
                            agent_name: "",
                            agent_phone: "",
                            agent_email: "",
                            agent_assistant_name: "",
                            agent_assistant_phone: "",
                        },
                        management_firm: {
                            name: "",
                            manager_name: "",
                            manager_phone: "",
                            manager_email: "",
                            manager_assistant_name: "",
                            manager_assistant_phone: "",
                            manager_assistant_email: "",
                        },
                        publicity_firm: {
                            name: "",
                            publicist_name: "",
                            publicist_phone: "",
                            publicist_email: "",
                            publicist_assistant_name: "",
                            publicist_assistant_phone: "",
                            publicist_assistant_email: "",
                            facebook: "",
                            twitter: "",
                            instagram: "",
                            website: "",
                            apple_music: "",
                            spotify: "",
                            sound_cloud: "",
                        },
                        cancellation_terms: "",
                        stages_time_slots: [],
                    };
                    break;
                case "modal":
                    result = {
                        show: false,
                        title: "",
                        add: false,
                        edit: false,
                        delete: false,
                    };
                    break;
                case "statusForm":
                    result = {
                        status: null,
                        hold_position: null,
                        time: null,
                    };
                    break;
            }
            return result;
        },
        fetchStatus(value, type) {
            if (type === "key") {
                for (let i = 0; i < this.rawStatuses.length; i++) {
                    if (this.rawStatuses[i] === value) {
                        return i;
                    }
                }
            } else {
                return this.rawStatuses[value];
            }
        },
        fetchHoldPosition(value, type) {
            if (type === "key") {
                for (let i = 0; i < this.rawHoldPositions.length; i++) {
                    if (this.rawHoldPositions[i] === value) {
                        return i;
                    }
                }
            } else {
                return this.rawHoldPositions[value];
            }
        },
        save(sendEmail = false) {
            let loader = this.$loading.show();
            let customRequest = null;
            if (this.modal.delete) {
                customRequest = this.$http.delete(
                    "events/" + this.event.id + "/artists/" + this.form.id
                );
            } else if (this.modal.edit) {
                let postParam = cloneDeep({
                    ...this.form,
                    promoter_profit: this.form.promoter_profit_enable
                        ? this.form.promoter_profit
                        : 0,
                    send_email: sendEmail,
                });
                customRequest = this.$http.put(
                    "events/" +
                        this.event.id +
                        "/artists/" +
                        this.form.id.value,
                    postParam
                );
            } else if (this.modal.add) {
                let postParam = cloneDeep({
                    ...this.form,
                    promoter_profit: this.form.promoter_profit_enable
                        ? this.form.promoter_profit
                        : 0,
                    id: null,
                    artist_id: this.form.id.value,
                    send_email: sendEmail,
                });
                customRequest = this.$http.post(
                    "events/" + this.event.id + "/artists",
                    postParam
                );
            }

            if (customRequest !== null) {
                customRequest
                    .then((response) => {
                        if (this.modal.add) {
                            this.$emit("artistEvent", {
                                type: "add",
                                data: {
                                    id: this.form.id.value,
                                    name: this.form.id.label,
                                    image: this.form.id.image,
                                    type: this.form.type,
                                    category: [0, 3, 4, 6, 9, 10, 11].includes(
                                        this.form.status
                                    )
                                        ? "historical"
                                        : this.form.type,
                                    promoter_profit: this.form
                                        .promoter_profit_enable
                                        ? this.form.promoter_profit
                                        : 0,
                                    date_notes: this.form.date_notes,
                                    notes: this.form.notes,
                                    amount: this.form.amount,
                                    status_color: this.statusColor[
                                        this.fetchStatus(
                                            this.form.status,
                                            "value"
                                        )
                                    ],
                                    hold_position_order: this.form
                                        .hold_position,
                                    hold_position_color: this.holdPositionColor[
                                        this.fetchHoldPosition(
                                            this.form.hold_position,
                                            "value"
                                        )
                                    ],
                                    agency: this.form.agency,
                                    management_firm: this.form.management_firm,
                                    publicity_firm: this.form.publicity_firm,
                                    artist_representative_mad: {
                                        dates: [],
                                        notes: "",
                                    },
                                    my_activities: this.form.stages_time_slots,
                                },
                            });
                            this.fetchActivities();
                        } else if (this.modal.edit) {
                            let oldPosition = null,
                                updateArtist = false;
                            for (let i = 0; i < this.artists.length; i++) {
                                if (this.artists[i].id === this.form.id.value) {
                                    // Update other artists hold positions
                                    oldPosition = this.fetchHoldPosition(
                                        this.artists[i].hold_position,
                                        "key"
                                    );

                                    if (
                                        this.fetchStatus(
                                            this.artists[i].status,
                                            "key"
                                        ) === 5
                                    ) {
                                        let firstHoldPosArtist = this.artists.find(
                                            (val) => {
                                                return (
                                                    this.fetchHoldPosition(
                                                        val.hold_position,
                                                        "key"
                                                    ) === 2
                                                );
                                            }
                                        );

                                        this.$emit("artistEvent", {
                                            type: "update",
                                            id: firstHoldPosArtist.id,
                                            data: {
                                                status: this.fetchStatus(
                                                    12,
                                                    "value"
                                                ),
                                                status_color: this.statusColor[
                                                    this.fetchStatus(
                                                        12,
                                                        "value"
                                                    )
                                                ],
                                            },
                                        });

                                        this.$emit("eventUpdate", {
                                            challenge: {
                                                to: {
                                                    id: firstHoldPosArtist.id,
                                                    name:
                                                        firstHoldPosArtist.name,
                                                },
                                                by: {
                                                    id: this.artists[i].id,
                                                    name: this.artists[i].name,
                                                },
                                                end_at: moment
                                                    .utc()
                                                    .add(
                                                        this.form
                                                            .challenged_hours,
                                                        "hours"
                                                    )
                                                    .format(
                                                        "YYYY-MM-DD HH:mm:ss"
                                                    ),
                                            },
                                        });
                                    }

                                    this.$emit("artistEvent", {
                                        type: "update",
                                        id: this.form.id.value,
                                        data: {
                                            type: this.form.type,
                                            category: [
                                                0,
                                                3,
                                                4,
                                                6,
                                                9,
                                                10,
                                                11,
                                            ].includes(this.form.status)
                                                ? "historical"
                                                : this.form.type,
                                            promoter_profit: this
                                                .promoter_profit_enable
                                                ? this.form.promoter_profit
                                                : 0,
                                            date_notes: this.form.date_notes,
                                            notes: this.form.notes,
                                            amount: this.form.amount,
                                            status_color: this.statusColor[
                                                this.fetchStatus(
                                                    this.form.status,
                                                    "value"
                                                )
                                            ],
                                            hold_position_order: this.form
                                                .hold_position,
                                            hold_position_color: this
                                                .holdPositionColor[
                                                this.fetchHoldPosition(
                                                    this.form.hold_position,
                                                    "value"
                                                )
                                            ],
                                            agency: this.form.agency,
                                            management_firm: this.form
                                                .management_firm,
                                            publicity_firm: this.form
                                                .publicity_firm,
                                            offer_expiration_date:
                                                this.form.status === 7
                                                    ? moment
                                                          .utc()
                                                          .add(
                                                              this.form
                                                                  .offer_expiration_time,
                                                              "hours"
                                                          )
                                                          .format(
                                                              "YYYY-MM-DD HH:mm:ss"
                                                          )
                                                    : null,
                                            cancellation_terms: this.form
                                                .cancellation_terms,
                                            my_activities: this.form
                                                .stages_time_slots,
                                        },
                                    });

                                    if ([2, 3, 4, 5, 6].includes(oldPosition)) {
                                        if (
                                            oldPosition !==
                                            this.form.hold_position
                                        ) {
                                            updateArtist = true;
                                        }
                                    }
                                    break;
                                }
                            }

                            if (updateArtist === true) {
                                let posToUpdate = [];
                                for (let i = 6; i > oldPosition; i--) {
                                    posToUpdate.push(i);
                                }

                                for (let i = 0; i < this.artists.length; i++) {
                                    let currPos = this.fetchHoldPosition(
                                        this.artists[i].hold_position,
                                        "key"
                                    );
                                    if (
                                        this.artists[i].id !==
                                            this.form.id.value &&
                                        posToUpdate.includes(currPos) &&
                                        currPos > oldPosition
                                    ) {
                                        let posName = this.fetchHoldPosition(
                                            currPos - 1,
                                            "value"
                                        );
                                        this.$emit("artistEvent", {
                                            type: "update",
                                            id: this.artists[i].id,
                                            data: {
                                                hold_position: posName,
                                                hold_position_order:
                                                    currPos - 1,
                                                hold_position_color: this
                                                    .holdPositionColor[posName],
                                            },
                                        });
                                    }
                                }
                            }
                        } else if (this.modal.delete) {
                            let oldPosition = null,
                                updateArtist = false;
                            for (let i = 0; i < this.artists.length; i++) {
                                if (this.artists[i].id === this.form.id) {
                                    // Update other artists hold positions
                                    oldPosition = this.fetchHoldPosition(
                                        this.artists[i].hold_position,
                                        "key"
                                    );
                                    if ([2, 3, 4, 5, 6].includes(oldPosition)) {
                                        updateArtist = true;
                                    }
                                    break;
                                }
                            }

                            if (updateArtist === true) {
                                let posToUpdate = [];
                                for (let i = 6; i > oldPosition; i--) {
                                    posToUpdate.push(i);
                                }

                                for (let i = 0; i < this.artists.length; i++) {
                                    let currPos = this.fetchHoldPosition(
                                        this.artists[i].hold_position,
                                        "key"
                                    );
                                    if (
                                        this.artists[i].id !== this.form.id &&
                                        posToUpdate.includes(currPos) &&
                                        currPos > oldPosition
                                    ) {
                                        let posName = this.fetchHoldPosition(
                                            currPos - 1,
                                            "value"
                                        );
                                        this.$emit("artistEvent", {
                                            type: "update",
                                            id: this.artists[i].id,
                                            data: {
                                                hold_position: posName,
                                                hold_position_order:
                                                    currPos - 1,
                                                hold_position_color: this
                                                    .holdPositionColor[posName],
                                            },
                                        });
                                    }
                                }
                            }

                            this.$emit("artistEvent", {
                                type: "remove",
                                id: this.form.id,
                            });
                        }
                        this.cancel();
                        this.$toastr.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                    })
                    .catch((error) => {
                        this.$toastr.fire({
                            icon: "error",
                            title: error.response.data.message,
                        });
                    })
                    .then(() => {
                        loader.hide();
                    });
            } else {
                loader.hide();
            }
        },
        setHoldPositions(status = null) {
            if (status === 6) {
                return;
            }
            if (this.form.id === "") {
                this.form.hold_position = null;
            }
            this.holdPositions = [
                {
                    value: null,
                    text: "Please select hold position",
                },
            ];
            let hidePositions = [];

            switch (status) {
                case 0:
                    hidePositions.push(1, 2, 3, 4, 5, 6, 7);
                    this.form.type = "headliner";
                    break;
                case 1:
                    hidePositions.push(1, 2, 3, 4, 5, 6, 7);
                    this.form.type = "historical";
                    break;
                case 2:
                    hidePositions.push(1, 7, ...this.assignedHoldPositions);
                    this.form.type = "headliner";
                    break;
                case 3:
                    hidePositions.push(2, 3, 4, 5, 6);
                    this.form.type = "historical";
                    break;
                case 4:
                    hidePositions.push(1, 2, 3, 4, 5, 6);
                    this.form.type = "historical";
                    break;
                case 5:
                    hidePositions.push(0, 1, 4, 5, 6, 7);
                    this.form.type = "headliner";
                    break;
                case 6:
                    hidePositions.push(1);
                    this.form.type = "historical";
                    break;
                case 7:
                    hidePositions.push(0, 2, 3, 4, 5, 6, 7);
                    this.form.type = "headliner";
                    break;
                case 8:
                    hidePositions.push(0, 2, 3, 4, 5, 6, 7);
                    this.form.type = "headliner";
                    break;
                case 9:
                    hidePositions.push(2, 3, 4, 5, 6);
                    this.form.type = "historical";
                    break;
                case 10:
                    hidePositions.push(1, 2, 3, 4, 5, 6);
                    this.form.type = "historical";
                    break;
                case 11:
                    hidePositions.push(0, 2, 3, 4, 5, 6, 7);
                    this.form.type = "historical";
                    break;
                default:
                    if (this.assignedHoldPositions.length > 0) {
                        hidePositions.push(...this.assignedHoldPositions);
                    }
                    break;
            }

            let selectionExists = false;

            for (let i = 0; i < this.rawHoldPositions.length; i++) {
                if (hidePositions.length === 0 || !hidePositions.includes(i)) {
                    this.holdPositions.push({
                        value: i,
                        text: this.rawHoldPositions[i],
                    });
                    if (i === this.form.hold_position) {
                        selectionExists = true;
                    }
                }
            }
            if (selectionExists === false) {
                this.form.hold_position = null;
            }
        },
        setAssignedHoldPositions() {
            this.assignedHoldPositions = [];
            let artistId = this.form.id !== "" ? this.form.id.value : "";
            for (let i = 0; i < this.artists.length; i++) {
                if (artistId !== this.artists[i].id) {
                    this.assignedHoldPositions.push(
                        this.fetchHoldPosition(
                            this.artists[i].hold_position,
                            "key"
                        )
                    );
                }
            }
        },
        setStatuses() {
            this.statuses = [
                {
                    value: null,
                    text: "Please select status",
                },
            ];

            let firstHoldPresent = false;
            for (let i = 0; i < this.artists.length; i++) {
                if (
                    this.fetchHoldPosition(
                        this.artists[i].hold_position,
                        "key"
                    ) === 2
                ) {
                    firstHoldPresent = true;
                }
            }

            for (let i = 0; i < this.rawStatuses.length; i++) {
                let canPush = false;
                if (this.form.status === i) {
                    canPush = true;
                } else if (
                    i === 12 &&
                    this.modal.edit === true &&
                    this.form.status === 12
                ) {
                    canPush = true;
                } else if (
                    i !== 12 &&
                    (i !== 5 ||
                        (firstHoldPresent && this.form.hold_position === 3))
                ) {
                    canPush = true;
                }

                if (canPush === true) {
                    this.statuses.push({
                        value: i,
                        text: this.rawStatuses[i],
                    });
                }
            }
        },
        setChallengeData() {
            if (this.event.challenge === null) {
                this.challengeData = cloneDeep(this.event.challenge);
            } else {
                for (let i = 0; i < this.artists.length; i++) {
                    let tempPos = this.fetchHoldPosition(
                        this.artists[i].status,
                        "key"
                    );
                    if (tempPos === 2) {
                        // this.challengeData
                    }
                }
            }
            // this.challengeData;
        },
        async updateTimeSlotsForStage(e) {
            if (e.target.checked === true) {
                this.showStatusModal = true;
                this.statusForm.time = this.rawTimeSlots[0].value;
            } else {
                for (let i = 0; i < this.form.stages_time_slots.length; i++) {
                    if (
                        this.form.stages_time_slots[i].stage.id ===
                        this.selectedStage
                    ) {
                        for (
                            let j = 0;
                            j < this.form.stages_time_slots[i].slots.length;
                            j++
                        ) {
                            let timeSlotStr =
                                this.form.stages_time_slots[i].slots[j].time
                                    .start +
                                "," +
                                this.form.stages_time_slots[i].slots[j].time
                                    .end;
                            if (timeSlotStr === e.target.value) {
                                this.form.stages_time_slots[i].slots.splice(
                                    j,
                                    1
                                );

                                for (
                                    let k = 0;
                                    k < this.selectedTimeSlots.length;
                                    k++
                                ) {
                                    if (
                                        this.selectedTimeSlots[k] ===
                                        timeSlotStr
                                    ) {
                                        this.selectedTimeSlots.splice(k, 1);
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                        if (
                            this.form.stages_time_slots[i].time_slots.length ===
                            0
                        ) {
                            this.form.stages_time_slots.splice(i, 1);
                        }
                        break;
                    }
                }
            }
        },
        async showTimeSlotsForStage() {
            await this.$nextTick();
            this.timeSlots = [];
            this.selectedTimeSlots = [];

            let occupiedSlots = [],
                selectedSlots = [];

            for (let i = 0; i < this.form.stages_time_slots.length; i++) {
                for (
                    let j = 0;
                    j < this.form.stages_time_slots[i].slots.length;
                    j++
                ) {
                    let tempTimes =
                        this.form.stages_time_slots[i].slots[j].time.start +
                        "," +
                        this.form.stages_time_slots[i].slots[j].time.end;
                    if (
                        this.form.stages_time_slots[i].stage.id ===
                        this.selectedStage
                    ) {
                        if (!selectedSlots.includes(tempTimes)) {
                            selectedSlots.push(tempTimes);
                        }
                    } else {
                        if (!occupiedSlots.includes(tempTimes)) {
                            occupiedSlots.push(tempTimes);
                        }
                    }
                }
            }

            for (let i = 0; i < this.rawTimeSlots.length; i++) {
                if (!occupiedSlots.includes(this.rawTimeSlots[i].value)) {
                    this.timeSlots.push(cloneDeep(this.rawTimeSlots[i]));
                }
                if (selectedSlots.includes(this.rawTimeSlots[i].value)) {
                    this.selectedTimeSlots.push(this.rawTimeSlots[i].value);
                }
            }
        },
        cancelStatusModal() {
            let totalStagesTimeSlots = this.form.stages_time_slots.length;
            if (totalStagesTimeSlots > 0) {
                for (let i = 0; i < totalStagesTimeSlots; i++) {
                    if (
                        this.form.stages_time_slots[i].stage.id ===
                        this.selectedStage
                    ) {
                        for (
                            let j = 0;
                            j < this.form.stages_time_slots[i].slots.length;
                            j++
                        ) {
                            let timeSlotStr =
                                this.form.stages_time_slots[i].slots[j].time
                                    .start +
                                "," +
                                this.form.stages_time_slots[i].slots[j].time
                                    .end;

                            if (timeSlotStr === this.statusForm.time) {
                                this.form.stages_time_slots[i].slots.splice(
                                    j,
                                    1
                                );
                                break;
                            }
                        }
                        if (this.form.stages_time_slots[i].slots.length === 0) {
                            this.form.stages_time_slots.splice(i, 1);
                        }
                        break;
                    }
                }

                for (let i = 0; i < this.selectedTimeSlots.length; i++) {
                    if (this.selectedTimeSlots[i] === this.statusForm.time) {
                        this.selectedTimeSlots.splice(i, 1);
                        break;
                    }
                }
            } else {
                this.selectedTimeSlots = [];
            }
            this.statusForm = this.default("statusForm");
            this.showStatusModal = false;
        },
        saveStatus() {
            if (this.statusForm.status === null) {
                this.$toastr.fire({
                    toast: true,
                    icon: "error",
                    title: "Please select status",
                });
            } else if (this.statusForm.hold_position === null) {
                this.$toastr.fire({
                    toast: true,
                    icon: "error",
                    title: "Please select hold position",
                });
            } else {
                let insertNew = true;
                let totalStagesTimeSlots = this.form.stages_time_slots.length;
                let time = this.statusForm.time.split(",");
                console.log(time);

                for (let i = 0; i < totalStagesTimeSlots; i++) {
                    if (
                        this.form.stages_time_slots[i].stage.id ===
                        this.selectedStage
                    ) {
                        this.form.stages_time_slots[i].slots.push({
                            time: {
                                start: Number(time[0]),
                                end: Number(time[1]),
                            },
                            status: this.statusForm.status,
                            hold_position: this.statusForm.hold_position,
                        });
                        insertNew = false;
                    }
                }

                if (insertNew === true) {
                    let tempStage = this.stages.find((stage) => {
                        return stage.value === this.selectedStage;
                    });
                    this.form.stages_time_slots.push({
                        stage: {
                            id: tempStage.value,
                            name: tempStage.text,
                        },
                        slots: [
                            {
                                time: {
                                    start: Number(time[0]),
                                    end: Number(time[1]),
                                },
                                status: this.statusForm.status,
                                hold_position: this.statusForm.hold_position,
                            },
                        ],
                    });
                }

                this.showStatusModal = false;
                this.statusForm = this.default("statusForm");
            }
        },
        fetchActivities(artistId) {
            this.$http
                .get(`events/${this.event.id}/activities?artist_id=${artistId}`)
                .then((response) => {
                    this.$emit("eventUpdate", {
                        activities: response.data.data,
                    });
                })
                .catch((error) => {
                    this.$toastr.fire({
                        toast: true,
                        icon: "error",
                        title: error.response.data.message,
                    });
                })
                .then(() => {
                    this.initiated = true;
                    this.setData();
                });
        },
        openEvent(evt, eventName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(
                    " active",
                    ""
                );
            }
            document.getElementById(eventName).style.display = " block";
            evt.currentTarget.className += " active";
        },
        openSub(evt, subName) {
            var i, subcontent, sublink;
            subcontent = document.getElementsByClassName("subcontent");
            for (i = 0; i < subcontent.length; i++) {
                subcontent[i].style.display = "none";
            }
            sublink = document.getElementsByClassName("sublink");
            for (i = 0; i < sublink.length; i++) {
                sublink[i].className = sublink[i].className.replace(
                    " sub-active",
                    ""
                );
            }
            document.getElementById(subName).style.display = "block";
            evt.currentTarget.className += " sub-active";
        }
    },
};
</script>

<style scoped lang="scss">
.offer-terms {
    .tabs {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    button {
        border: none;
        outline: none;
        background: transparent;
        cursor: pointer;
    }
    .tablink {
        font-size: 1.1rem;
        font-weight: 400;
        background-image: linear-gradient(
            120deg,
            transparent 0%,
            transparent 50%,
            #6f42c1 50%
        );
        background-size: 230%;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease-out;
        border-radius: 20px;
    }
    .tablink:hover {
        background-position: 100%;
        color: white;
        transform: translateX(-5%);
    }
    .bold-color {
        color: #6f42c1;
        font-weight: 700;
    }
    .tabcontent {
        display: none;
        padding: 1rem;
    }
    .active {
        background-color: #6f42c1;
        color: white;
    }
    .subtab {
        display: flex;
        /* justify-content: center; */
        gap: 1rem;
    }
    .sublink {
        padding: 0.5rem 1rem;
        color: #a6a6a6;
        font-size: 1.03rem;
    }
    .sub-active {
        color: #6f42c1;
        font-weight: 600;
        border-bottom: 1.5px solid #6f42c1;
        transition: border-bottom 0.1s ease;
    }
    .group {
        position: relative;
        width: 35%;
    }
    .group label {
        position: absolute;
        pointer-events: none;
        font-size: 1rem;
        left: 4%;
        top: 25%;
        color: #6f42c1;
        transition: all 0.3s ease;
    }
    .bar {
        position: relative;
        display: block;
        width: 100%;
    }
    .bar::after,
    .bar::before {
        content: "";
        height: 2px;
        position: absolute;
        width: 0;
        bottom: 0;
        background: #6f42c1;
        transition: all 0.2s ease;
    }
    .bar::before {
        left: 50%;
    }
    .bar::after {
        right: 50%;
    }
    .ak-input:focus ~ .bar::before,
    .ak-input:focus ~ .bar::after {
        width: 50%;
    }

    .ak-input:focus ~ label,
    .ak-input:valid ~ label {
        top: -44%;
        left: 2%;
        font-size: 0.8rem;
        color: #6f42c1;
    }
    .ak-input {
        outline: none;
        border: none;
        border-bottom: 1px solid #6f42c1;
        font-size: 1rem;
        width: 100%;
        background: transparent;
        padding: 0.5rem;
    }
    .subcontent {
        display: none;
        padding: 3rem 2rem;
    }
    .option-box {
        display: flex;
        color: black;
        align-items: center;
        justify-content: space-between;
    }
    .simple-input {
        border: none;
        border-bottom: 1.5px solid #6f42c1;
        outline: none;
        font-size: 1.05rem;
    }
    .align-center {
        display: flex;
        align-items: center;
    }
    .icon {
        width: 1.2rem;
        margin-right: 0.5rem;
        cursor: pointer;
    }
    .subcontent-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }
    .block-input {
        border: none;
        display: block;
        border-bottom: 1.5px solid #6f42c1;
        width: 3rem;
        font-size: 1.1rem;
        outline: none;
    }
    .value {
        color: #6f42c1;
        font-weight: bold;
    }
    .toggle-switch {
        margin: 0 !important;
    }
    .versus-box {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .box-input {
        border: none;
        background: transparent;
        outline: none;
        border-bottom: 1.5px solid #6f42c1;
        font-size: 1.1rem;
    }
    .input-box-container {
        display: flex;
        gap: 1rem;
        align-items: center;
        border: 1.5px solid #6f42c1;
        padding: 0.7rem 1.4rem;
        border-radius: 30px;
    }
    .vs {
        width: 1.8rem;
        height: 1.8rem;
        border: 1px solid black;
        border-radius: 50%;
        padding: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .toggle-switch > :checked + label::after,
    :checked + .toggle-switch-label::after {
        background: #6f42c1 !important;
    }
    .toggle-switch > :checked + label::before,
    :checked + .toggle-switch-label::before {
        background: #6f42c1 !important;
    }
    .check-option {
        display: flex;
        align-items: center;
        padding: 1rem 2rem;
    }
    .show-link {
        text-decoration: none;
        color: #6f42c1;
    }
    .hr {
        width: 100%;
        height: 2px;
        background-color: #6f42c1;
    }
    .color {
        color: #6f42c1;
    }
    .total-bill {
        padding: 1rem 2rem;
        display: flex;
        gap: 1rem;
        justify-content: center;
    }
    .bill-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }
    .artist-expenses {
        margin-top: 2rem;
        border: 1.5px solid #6f42c1;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        margin-bottom: 1rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    .add-desc {
        display: flex;
        align-items: center;
        margin: 0.2rem 0;
    }
    .artist-expense-box {
        display: flex;

        flex-direction: column;
        gap: 1rem;
    }
    .artist-expense-box-container {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
    }
    .icon-s {
        width: 0.8rem;
        height: 0.8rem;
        margin: 0.3rem;
        cursor: pointer;
    }
    .box-wrapper {
        display: flex;
        gap: 0.4rem;
    }
    .simple-input {
        line-height: 1.3;
    }
    .box-head {
        border-bottom: 1.5px solid #6f42c1;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        color: #6f42c1;
        font-weight: 600;
    }
    select {
        border-radius: 10px;
        font-size: 1.05rem;
        border: 1px solid #6f42c1;
        outline: none;
    }
    .text-hr {
        display: flex;
        align-items: center;
        width: 100%;
        gap: 1rem;
    }
    .text-hr::before {
        content: "";
        display: block;
        width: 50%;
        height: 1.5px;
        background-color: #6f42c1;
    }
    .text-hr::after {
        content: "";
        display: block;
        width: 50%;
        height: 1.5px;
        background-color: #6f42c1;
    }
    .ticket-table {
        width: 100%;
        font-size: 1.1rem;
        padding: 1rem;
    }
    .table {
        width: 100%;
        margin-top: 2rem;
        display: grid;
        grid-template-columns: 1.3fr 0.6fr 0.7fr 0.7fr 1.2fr 0.3fr;
        gap: 1rem;
        border: 1.5px solid #6f42c1;
        padding: 1rem;
    }
    .w-40 {
        width: 50%;
    }
    .table-container {
        display: flex;
        flex-direction: column;
        margin-bottom: 1rem;
    }
    .ticket-Fees {
        display: grid;
        grid-template-columns: 1fr 1fr;
        justify-content: space-between;
        padding: 1rem;
    }
    .ticket-fees-container {
        display: flex;
        flex-direction: column;

        border: 1.5px solid #6f42c1;
    }
    .mt-2 {
        margin-top: 2rem;
    }
    /* separate css */
    .toggle-switch {
        /** bar */
        --bar-height: 14px;
        --bar-width: 32px;
        --bar-color: #eee;

        /** knob */
        --knob-size: 20px;
        --knob-color: #fff;

        /** switch */
        --switch-offset: calc(var(--knob-size) - var(--bar-height));
        --switch-width: calc(var(--bar-width) + var(--switch-offset));
        --transition-duration: 200ms;
        --switch-transition: all var(--transition-duration) ease-in-out;
        --switch-theme-rgb: 26, 115, 232;
        --switch-theme-color: rgb(var(--switch-theme-rgb));
        --switch-box-shadow: 0 0 var(--switch-offset) #11111180;
        --switch-margin: 8px;

        position: relative;
        display: inline-flex;
        align-items: center;
        box-sizing: border-box;
        min-width: var(--bar-width);
        min-height: var(--bar-height);
        margin: var(--switch-margin);
        user-select: none;
    }

    .toggle-switch.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .toggle-switch > input,
    .toggle-switch-input {
        position: absolute;
        width: 0;
        height: 0;
        opacity: 0;
    }

    .toggle-switch > label,
    .toggle-switch-label {
        --knob-x: calc((var(--bar-height) - var(--bar-width)) / 2);

        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        width: var(--bar-width);
        height: var(--bar-height);
        margin: var(--switch-margin);
        user-select: none;
    }

    /* checked */
    .toggle-switch > :checked + label,
    :checked + .toggle-switch-label {
        --knob-x: calc((var(--bar-width) - var(--bar-height)) / 2);
    }

    /* bar */
    .toggle-switch > label::before,
    .toggle-switch-label::before {
        position: absolute;
        top: 0;
        left: 0;
        box-sizing: border-box;
        width: var(--bar-width);
        height: var(--bar-height);
        background: var(--bar-color);
        border: 1px solid var(--switch-theme-color);
        border-radius: var(--bar-height);
        opacity: 0.5;
        transition: var(--switch-transition);
        content: "";
    }

    /* checked bar */
    .toggle-switch > :checked + label::before,
    :checked + .toggle-switch-label::before {
        background: var(--switch-theme-color);
    }

    /* knob */
    .toggle-switch > label::after,
    .toggle-switch-label::after {
        box-sizing: border-box;
        width: var(--knob-size);
        height: var(--knob-size);
        background: var(--knob-color);
        border-radius: 50%;
        box-shadow: var(--switch-box-shadow);
        transform: translateX(var(--knob-x));
        transition: var(--switch-transition);
        content: "";
    }

    /* checked knob */
    .toggle-switch > :checked + label::after,
    :checked + .toggle-switch-label::after {
        background: var(--switch-theme-color);
    }

    /* hover & focus knob */
    .toggle-switch > :focus + label::after,
    :focus + .toggle-switch-label::after,
    .toggle-switch:hover > label::after,
    :hover > .toggle-switch-label::after {
        box-shadow: var(--switch-box-shadow),
            0 0 0 calc(var(--knob-size) / 2) rgba(var(--switch-theme-rgb), 0.2);
    }

}
</style>
