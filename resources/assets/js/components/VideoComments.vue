<template>
    <p>{{ comments.length }} {{ comments.length | pluralize 'comment' }}</p>

    <div class="video-comment clearfix" v-if="$root.user.authenticated">
        <textarea placeholder="Say something" class="form-control video-comment__input" v-model="body"></textarea>
        <div class="pull-right">
            <button type="submit" class="btn btn-default" @click.prevent="createComment">Post</button>
        </div>
    </div>

    <ul class="media-list">
        <li class="media" v-for="comment in comments">
            <div class="media-left">
                <a href="/channel/{{ comment.channel.data.slug }}">
                    <img :src="comment.channel.data.image" alt="{{ comment.channel.data.name }} image" class="media-object img-rounded">
                </a>
            </div>
            <div class="media-body">
                <a href="/channel/{{ comment.channel.data.slug }}">{{ comment.channel.data.name }}</a> {{ comment.created_at_human }}
                <p>{{ comment.body }}</p>

                <ul class="list-inline" v-if="$root.user.authenticated">
                    <li>
                        <a href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>
                    </li>
                    <li>
                        <a href="#" v-if="$root.user.id === comment.user_id" @click.prevent="deleteComment(comment.id)">Delete</a>
                    </li>
                </ul>

                <div class=".video-comment clearfix" v-if="replyFormVisible === comment.id">
                    <textarea class="form-control video-comment__input" v-model="replyBody"></textarea>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-default" @click.prevent="createReply(comment.id)">Reply</button>
                    </div>
                </div>

                <div class="media" v-for="reply in comment.replies.data">
                    <div class="media-left">
                        <a href="/channel/{{ reply.channel.data.slug }}">
                            <img :src="reply.channel.data.image" alt="{{ reply.channel.data.name }} image" class="media-object img-rounded">
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="/channel/{{ reply.channel.data.slug }}">{{ reply.channel.data.name }}</a> {{ reply.created_at_human }}
                        <p>{{ reply.body }}</p>

                        <ul class="list-inline" v-if="$root.user.authenticated">
                            <li>
                                <a href="#" v-if="$root.user.id === reply.user_id" @click.prevent="deleteComment(reply.id)">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {

        data () {
            return {

                comments: [],
                body: null,
                replyBody: null,
                replyFormVisible: null

            }
        },

        props : {
            videoUid: null
        },

        methods: {

            toggleReplyForm(commentId) {
                this.replyBody = null;

                if (this.replyFormVisible === commentId) {
                    this.replyFormVisible = null;
                    return;
                }

                this.replyFormVisible = commentId;
            },

            createReply (commentId) {
                this.$http.post('/videos/' + this.videoUid + '/comments', {
                    body: this.replyBody,
                    reply_id: commentId
                }).then((response) => {
                    this.comments.map((comment, index) => {
                        if (comment.id === commentId) {
                            this.comments[index].replies.data.push(response.json().data);
                            return;
                        }
                    });

                    this.replyBody = null;
                    this.replyFormVisible = null;
                });
            },

            createComment () {
                this.$http.post('/videos/' + this.videoUid + '/comments', {
                    body: this.body
                }).then((response) => {
                    this.comments.unshift(response.json().data);
                    this.body = null;
                });
            },

            getComments () {
                this.$http.get('/videos/' + this.videoUid + '/comments').then((response) => {
                    this.comments = response.json().data;
                });
            },

            deleteComment (commentId) {
                if (!confirm('Are you sure you want delete this comment?')) {
                    return;
                }

                this.$http.delete('/videos/' + this.videoUid + '/comments/' + commentId).then((response) => {
                    this.deleteById(commentId);
                });
            },

            deleteById (commentId) {
                this.comments.map((comment, index) => {
                    if (comment.id === commentId) {
                        this.comments.splice(index, 1);
                        return;
                    }

                    comment.replies.data.map((reply, replyIndex) => {
                        if (reply.id === commentId) {
                            this.comments[index].replies.data.splice(replyIndex, 1);
                            return;
                        }
                    });
                });
            }

        },

        ready () {
            this.getComments();
        }
    }
</script>