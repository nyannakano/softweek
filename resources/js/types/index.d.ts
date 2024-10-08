export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

export interface Event {
    id: number;
    title: string;
    company: string;
    speaker: string;
    day: Day;
    type: string;
}

export interface Drink {
    id: number;
    name: string;
}

export interface Subscription {
    events: Array<Event>,
    will_participate_happy_hour: boolean,
    transport: boolean,
    status: string,
}

export interface Metric {
    total_subscriptions: number;
    companies: number;
    hours_total: number;
    speakers: number;
}

export interface Day {
    name: string;
    period: string;
}

export interface ImagePartner {
    jedi: string[];
    master: string[];
    padawan: string[];
    force: string[];
    knight: string[];
}
