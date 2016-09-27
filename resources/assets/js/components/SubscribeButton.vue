<template>
    <div v-if="subscribers !== null">
        {{ subscribers }} {{ subscribers | pluralize 'subscriber' }} &nbsp;
        <button class="btn btn-xs btn-default" type="button" v-if="canSubscribe" @click.prevent="handle">{{ userSubscribed ? 'UnSubscribe' : 'Subscribe' }}</button>
    </div>
</template>

<script>
    export default {

        props: {
            channelSlug: null
        },

        data () {
            return {
                subscribers: null,
                userSubscribed: false,
                canSubscribe: false
            }
        },

        methods: {
            getSubscriptionStatus () {
                this.$http.get('/subscription/' + this.channelSlug).then((response) => {
                    this.subscribers = response.json().data.count;
                    this.userSubscribed = response.json().data.user_subscribed;
                    this.canSubscribe = response.json().data.can_subscribe;
                });
            },

            handle () {
                if (this.userSubscribed) {
                    this.unSubscribe();
                } else {
                    this.subscribe();
                }
            },

            subscribe () {
                this.userSubscribed = true;
                this.subscribers++;

                this.$http.post('/subscription/' + this.channelSlug);
            },

            unSubscribe () {
                this.userSubscribed = false;
                this.subscribers--;

                this.$http.delete('/subscription/' + this.channelSlug);
            }
        },

        ready () {
            this.getSubscriptionStatus();
        }
    }
</script>
