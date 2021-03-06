<template>
  <div>
    <vs-row v-if="games" vs-justify="space-around">
      <vs-col
        type="flex"
        class="p-3"
        vs-justify="center"
        vs-align="center"
        vs-w="3"
        vs-lg="3"
        vs-sm="12"
        v-for="(game, index) in games"
        :key="index"
      >
        <vs-card>
          <div slot="header">
            <h3>
              {{ game.title }}
            </h3>
          </div>
          <div slot="media">
            <iframe
              :src="`https://www.youtube.com/embed/${game.video_id}`"
              frameborder="0"
              allow="
                accelerometer;
                autoplay;
                clipboard-write;
                encrypted-media;
                gyroscope;
                picture-in-picture
              "
              allowfullscreen
            ></iframe>
          </div>
          <div>
            <span>
              {{ game.description }}
            </span>
          </div>
          <div slot="footer">
            <vs-row vs-justify="flex-end">
              <vs-button
                class="mr-1"
                color="primary"
                icon="visibility"
                type="gradient"
                :title="`View ${game.title}`"
                @click="viewGame(game.id)"
              ></vs-button>
              <vs-button
                class="mr-1"
                color="warning"
                icon="create"
                type="gradient"
                :title="`Edit ${game.title}`"
                @click="editGame(game.id)"
              ></vs-button>
              <vs-button
                class="mr-1"
                color="danger"
                icon="delete"
                type="gradient"
                :title="`Delete ${game.title}`"
                @click="deleteGame(game.id)"
              ></vs-button>
            </vs-row>
          </div>
        </vs-card>
      </vs-col>

      <ViewGame
        v-if="game.view"
        :gameId="game.selectedGameId"
        @closed="game.view = false"
      />

      <EditGame
        v-if="game.edit"
        :gameId="game.selectedGameId"
        :showDialog="game.edit"
        @closed="game.edit = false"
        @update-game="loadGames()"
      />

      <DeleteGame
        v-if="game.delete"
        :gameId="game.selectedGameId"
        @closed="game.delete = false"
        @delete-game="loadGames()"
      />
    </vs-row>
    <vs-row v-else vs-justify="space-around">
      <vs-col
        type="flex"
        class="p-5"
        vs-justify="center"
        vs-align="center"
        vs-w="12"
        vs-lg="12"
        vs-sm="12"
      >
        <img
          src="../../assets/404.svg"
          alt="Image that represents that the content was not found"
          width="50%"
        >
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import ViewGame from './View.vue';
import DeleteGame from './Delete.vue';
import EditGame from './Edit.vue';
import { EventBus } from '../../eventBus';

export default {
  name: 'GameCards',
  components: {
    ViewGame,
    EditGame,
    DeleteGame,
  },
  data() {
    return {
      games: [],
      game: {
        selectedGameId: 0,
        view: false,
        edit: false,
        delete: false,
      },
    };
  },
  computed: {
    webApiUrl: () => 'http://localhost:8080/gamenews/backend',
  },
  mounted() {
    this.loadGames();
    EventBus.$on('new-game', () => {
      this.loadGames();
    });
  },
  methods: {
    loadGames() {
      fetch(`${this.webApiUrl}/game`, {
        method: 'GET',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
      })
        .catch(() => {
          this.notify(
            'danger',
            'Oopss!',
            'Something was wrong on loading the games',
          );
        })
        .then((response) => response.json())
        .then((data) => {
          this.games = data.data;
        });
    },
    viewGame(gameId) {
      this.game.view = true;
      this.game.selectedGameId = gameId;
    },
    editGame(gameId) {
      this.game.edit = true;
      this.game.selectedGameId = gameId;
    },
    deleteGame(gameId) {
      this.game.delete = true;
      this.game.selectedGameId = gameId;
    },
    notify(color, title, text) {
      this.$vs.notify({
        color,
        title,
        text,
      });
    },
  },
};
</script>
