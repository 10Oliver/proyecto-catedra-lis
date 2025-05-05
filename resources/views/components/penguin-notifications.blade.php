{{-- resources/views/components/penguin-notifications.blade.php --}}
<div x-data="{
        notifications: [],
        displayDuration: 8000,
        soundEffect: false,

        addNotification({ variant = 'info', sender = null, title = null, message = null}) {
            const id = Date.now()
            const notification = { id, variant, sender, title, message }

            if (this.notifications.length >= 20) {
                this.notifications.splice(0, this.notifications.length - 19)
            }

            this.notifications.push(notification)

            if (this.soundEffect) {
                const notificationSound = new Audio('https://res.cloudinary.com/ds8pgw1pf/video/upload/v1728571480/penguinui/component-assets/sounds/ding.mp3')
                notificationSound.play().catch(console.error)
            }
        },
        removeNotification(id) {
            setTimeout(() => {
                this.notifications = this.notifications.filter(n => n.id !== id)
            }, 400);
        },
    }" 
    x-on:notify.window="addNotification($event.detail)"
>
    <div class="pointer-events-none fixed inset-x-8 top-0 z-50 flex max-w-full flex-col gap-2 px-6 py-6 md:right-0 md:max-w-sm">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-data="{ isVisible: false, timeout: null }"
                 x-show="isVisible"
                 x-init="$nextTick(() => { isVisible = true; timeout = setTimeout(() => { isVisible = false; removeNotification(notification.id) }, displayDuration) })"
                 x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                 x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => { isVisible = false; removeNotification(notification.id) }, displayDuration)"
                 x-transition:enter="transition duration-300 ease-out"
                 x-transition:enter-start="translate-y-8 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition duration-300 ease-in"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="-translate-x-24 opacity-0"
                 class="pointer-events-auto relative rounded-lg border bg-surface p-4 shadow-lg"
            >
                <div class="flex items-start gap-3">
                    <template x-if="notification.variant === 'success'">
                        <svg class="h-6 w-6 text-success mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </template>
                    <template x-if="notification.variant === 'danger'">
                        <svg class="h-6 w-6 text-danger mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </template>
                    <div class="flex-1">
                        <h3 x-text="notification.title" class="font-semibold text-sm mb-1"></h3>
                        <p x-text="notification.message" class="text-sm"></p>
                    </div>
                    <button @click="(isVisible = false), removeNotification(notification.id)" class="ml-2 text-gray-400 hover:text-gray-600">
                        &times;
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
