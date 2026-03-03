import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import type { Ref } from 'vue';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function handleClickOutside(
    event: MouseEvent,
    ref: Ref,
    callback: Function,
) {
    if (!ref.value) return;

    if (!ref.value.contains(event.target as Node)) {
        callback();
    }
}

export function setFixedBody(value: boolean) {
    const body = document.querySelector('body');
    if (value) {
        body?.classList.add('b-fixed');
    } else {
        body?.classList.remove('b-fixed');
    }
}
