<template>
  <div class="flex h-[90vh] overflow-hidden">
    <!-- Partie gauche : Liste des conversations -->
    <div class="w-120 border-r border-b border-custom-white bg-custom-white px-14 pt-10 pb-6 flex flex-col">
      <h2 class="text-lg font-medium text-primary mb-1">Bonjour</h2>
      <h1 class="text-5xl font-medium text-primary mb-6 uppercase">{{ user.name }}</h1>
      <h3 class="text-4xl font-medium text-primary mb-4">Chats</h3>

      <!-- Boutons "Tous" et "Non lus" -->
      <div class="mb-4 flex gap-2">
        <button
          @click="filterType = 'all'"
          :class="[
            'text-sm font-medium px-4 py-1.5 rounded-full border transition',
            filterType === 'all' ? 'bg-primary text-white' : 'border-primary text-primary bg-transparent'
          ]"
        >
          Tous
        </button>
        <button
          @click="filterType = 'unread'"
          :class="[
            'text-sm font-medium px-4 py-1.5 rounded-full border transition',
            filterType === 'unread' ? 'bg-primary text-white' : 'border-primary text-primary bg-transparent'
          ]"
        >
          Non lus
        </button>
      </div>

      <!-- Liste des conversations -->
      <div v-if="conversations.length === 0" class="flex-1 flex items-center justify-center text-gray-500">
        <p>Aucun message</p>
      </div>
      <div v-else class="overflow-y-auto hide-scrollbar flex-1 space-y-4">
        <div
           v-for="conv in conversations"
          :key="conv.id"
          class="flex items-center justify-between hover:bg-white px-2 py-3 rounded-lg cursor-pointer transition"
          :class="{ 'bg-white': conv.id === selectedConversationId }"
          @click="selectConversation(conv.id)"
        >
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">
              {{ conv.titleText?.charAt(0) }}
            </div>
            <div class="flex flex-col text-sm">
              <span class="text-black font-semibold">{{ conv.titleText }}</span>
              <span class="text-xs text-gray-500">Disons {{ conv.proposed_price }} € !</span>
            </div>
          </div>
          <div class="text-xs text-gray-500">
            {{ conv.time || '10h32' }}
          </div>
        </div>
      </div>
    </div>

    <!-- Partie droite : Discussion -->
    <div class="flex-1 flex flex-col bg-custom-white px-10 py-4 relative border-l border-custom-white">
      <!-- Liste des messages -->
      <div class="space-y-3 max-w-2xl mx-auto mb-4">
        <div v-for="msg in negotiationHistory" :key="msg.id" class="flex">
          <div
            class="p-4 rounded-xl text-sm shadow-md max-w-xs"
            :class="{
              'ml-auto bg-primary text-white': msg.user_id === user.id,
              'mr-auto bg-soft-green text-white': msg.user_id !== user.id
            }"
          >
            <span class="block">
              {{ msg.user_id === user.id ? 'Vous proposez' : (user.role === 'hotelier' ? 'Le client propose' : 'L’hôtelier propose') }}
              {{ msg.proposed_price }} €
            </span>
            <p v-if="msg.status === 'accepted'" class="text-white/80 text-xs mt-1 font-semibold">Acceptée</p>
            <p v-if="msg.status === 'refused'" class="text-red-200 text-xs mt-1 font-semibold">Refusée</p>
            <p v-if="msg.status === 'countered'" class="text-yellow-300 text-xs mt-1 font-semibold">Contre-offre</p>
          </div>
        </div>
      </div>

      <!-- Footer des actions -->
      <div class="max-w-2xl mx-auto space-y-4 pb-6 mt-auto">
        <div v-if="lastNegotiation" class="text-center text-sm text-gray-500">
          Réduction : <span class="font-bold text-primary">-{{ discountPercent }}%</span>
        </div>

        <!-- Prix ajustable -->
        <div class="flex items-center justify-center bg-white rounded-full px-4 py-2 shadow-sm border w-fit mx-auto space-x-2 mb-4">
          <button @click="adjustPrice(-10)" class="text-gray-700 font-bold">-10</button>
          <button @click="adjustPrice(-1)" class="text-gray-700 font-bold">-1</button>
          <input v-model="price" type="number" class="text-center text-xl font-semibold w-24 outline-none border-0" />
          <button @click="adjustPrice(1)" class="text-gray-700 font-bold">+1</button>
          <button @click="adjustPrice(10)" class="text-gray-700 font-bold">+10</button>
        </div>

        <!-- Boutons d'action -->
        <div class="w-full max-w-xs space-y-2 mx-auto">
          <button v-if="user.role === 'voyageur' && (lastNegotiation?.status === 'pending' || (!hasMadeOffer && lastNegotiation?.status === 'countered'))" @click="submitPrice" class="w-full bg-primary text-white font-semibold py-2 rounded-full shadow hover:opacity-90">Soumettre</button>

          <button v-if="user.role === 'hotelier' && canAccept" @click="acceptPrice" class="w-full bg-primary text-white font-semibold py-2 rounded-full hover:opacity-90">Accepter</button>
          <button v-if="user.role === 'hotelier' && canAccept" @click="declinePrice" class="w-full bg-primary text-white font-semibold py-2 rounded-full hover:opacity-80">Refuser</button>
          <button v-if="user.role === 'hotelier' && canAccept" @click="submitPrice" class="w-full bg-primary text-white font-semibold py-2 rounded-full hover:opacity-80">Proposer un nouveau prix</button>

          <button
            v-if="user.role === 'voyageur' && lastNegotiation?.status === 'accepted'"
            @click="goToReservation"
            class="w-full bg-primary text-white font-semibold py-2 rounded-full hover:opacity-80"
          >
            Passer à la réservation
          </button>

          <button v-if="user.role === 'voyageur' && lastNegotiation?.status === 'accepted'" @click="submitPrice" class="w-full bg-primary text-white font-semibold py-2 rounded-full hover:opacity-80">Proposer un nouveau prix</button>

          <button v-if="user.role === 'voyageur' && lastNegotiation?.status === 'countered' && !hasMadeOffer" @click="acceptPrice" class="w-full bg-primary text-white font-semibold py-2 rounded-full hover:opacity-80">Accepter la contre-offre</button>
          <button v-if="user.role === 'voyageur' && lastNegotiation?.status === 'countered' && !hasMadeOffer" @click="submitPrice" class="w-full bg-primary text-white font-semibold py-2 rounded-full hover:bg-opacity-80">Faire une nouvelle proposition</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  getUserNegotiations,
  getHotelierNegotiations,
  startNegotiation,
  getNegotiationHistoryByRoom,
  submitCounterOffer,
  acceptNegotiation,
  declineNegotiation,
  submitNewOffer
} from '~/lib/negociation'
import { api } from '~/lib/api'

const conversations = ref([])
const selectedConversationId = ref(null)
const negotiationHistory = ref([])
const route = useRoute()
const router = useRouter()

const price = ref(100)
const initialPrice = ref(100)
const user = ref({})

const lastNegotiation = computed(() => negotiationHistory.value.at(-1) || null)
const hasMadeOffer = computed(() => lastNegotiation.value?.user_id === user.value?.id)
const canAccept = computed(() => {
  if (!lastNegotiation.value || !user.value) return false
  return lastNegotiation.value.user_id !== user.value.id &&
    ['proposed', 'countered'].includes(lastNegotiation.value.status)
})

const discountPercent = computed(() => {
  if (!initialPrice.value || !price.value) return 0
  return Math.round((1 - price.value / initialPrice.value) * 100)
})

async function loadNegotiations() {
  const negotiations = user.value.role === 'hotelier'
    ? await getHotelierNegotiations()
    : await getUserNegotiations()

  conversations.value = negotiations
    .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    .map(n => ({
      id: n.id,
      room_id: n.room.id,
      titleText: `${n.room.name} - ${n.room.hotel.name}`,
      status: n.status,
      proposed_price: n.proposed_price
    }))
}

onMounted(async () => {
  const userRes = await api.get('/api/user')
  user.value = userRes.data

  const roomId = route.query.room_id

  await loadNegotiations()

  if (roomId && user.value.role === 'voyageur') {
    const existing = conversations.value.find(c => c.room_id == roomId)
    if (!existing) {
      const response = await startNegotiation({ room_id: roomId, user_id: user.value.id })
      const room = await api.get(`/api/rooms/${roomId}`)

      // 🔥 Ajoute directement en haut sans attendre
      conversations.value.unshift({
        id: response.data.id,
        room_id: roomId,
        titleText: `${room.data.name} - ${room.data.hotel.name}`,
        status: response.data.status,
        proposed_price: response.data.proposed_price
      })

      await selectConversation(response.data.id)
    } else {
      await selectConversation(existing.id)
    }
    router.replace({ path: '/negociation' })
  }
})

async function selectConversation(id) {
  selectedConversationId.value = id
  const selected = conversations.value.find(c => c.id === id)
  if (selected) {
    const history = await getNegotiationHistoryByRoom(selected.room_id)
    negotiationHistory.value = history
    if (history.length > 0) {
      initialPrice.value = parseFloat(history[0].initial_price)
      price.value = parseFloat(history.at(-1).proposed_price || history[0].initial_price)
    }
  }
}

function adjustPrice(amount) {
  price.value = Math.max(1, price.value + amount)
}

async function submitPrice() {
  try {
    const selected = conversations.value.find(c => c.id === selectedConversationId.value)
    const res = negotiationHistory.value.length === 0
      ? await submitNewOffer(selected.room_id, price.value)
      : await submitCounterOffer(lastNegotiation.value.id, price.value)

    negotiationHistory.value.push(res.data.negotiation || res.data)

    if (selected) {
      selected.status = res.data.negotiation?.status || res.data.status
      selected.proposed_price = res.data.negotiation?.proposed_price || res.data.proposed_price
    }
  } catch (err) {
    console.error('[SUBMIT ERROR]', err)
  }
}

async function acceptPrice() {
  await acceptNegotiation(lastNegotiation.value.id)
  lastNegotiation.value.status = 'accepted'

  const selected = conversations.value.find(c => c.id === selectedConversationId.value)
  if (selected) selected.status = 'accepted'
}

async function declinePrice() {
  await declineNegotiation(lastNegotiation.value.id)
  lastNegotiation.value.status = 'refused'

  const selected = conversations.value.find(c => c.id === selectedConversationId.value)
  if (selected) selected.status = 'refused'
}

function goToReservation() {
  const selected = conversations.value.find(c => c.id === selectedConversationId.value)
  if (!selected || !lastNegotiation.value) return

  router.push({
    path: '/reservation',
    query: {
      room_id: selected.room_id,
      price: lastNegotiation.value.proposed_price,
      negotiation_id: selected.id
    }
  })
}


</script>

<style scoped>
.hide-scrollbar {
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
</style>




<style scoped>
.hide-scrollbar {
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
</style>
