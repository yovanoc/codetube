<template>
    <div v-if="subscribers !== null">
        {{ pluralize(this.subscribers, 'subscriber') }} &nbsp;
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
            pluralize (count, word) {
              if (count === 0) {
                return '0 ' + word + 's'
              } else if (count === 1) {
                return '1 ' + word
              } else {
                return count + ' ' + word + 's'
              }
            },

            getSubscriptionStatus () {
                axios.get('/subscription/' + this.channelSlug).then((response) => {
                    this.subscribers = response.data.count
                    this.userSubscribed = response.data.user_subscribed
                    this.canSubscribe = response.data.can_subscribe
                })
            },

            handle () {
                if (this.userSubscribed) {
                    this.unSubscribe()
                } else {
                    this.subscribe()
                }
            },

            subscribe () {
                this.userSubscribed = true
                this.subscribers++

                axios.post('/subscription/' + this.channelSlug)
            },

            unSubscribe () {
                this.userSubscribed = false
                this.subscribers--

                axios.delete('/subscription/' + this.channelSlug)
            }
        },

        mounted () {
            this.getSubscriptionStatus()
        }
    }
</script>
