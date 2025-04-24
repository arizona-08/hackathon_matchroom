
<template>
  <div class="flex h-screen overflow-hidden">
    <div class="w-72 border-r bg-white p-4 flex flex-col">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Messages</h2>
      </div>
      <div class="mb-4 flex gap-2">
        <button class="text-sm font-medium px-3 py-1 border rounded bg-black text-white">Tous</button>
        <button class="text-sm font-medium px-3 py-1 border rounded text-black">Non lus</button>
      </div>
      <div v-if="conversations.length === 0" class="flex-1 flex items-center justify-center text-gray-500">
        <p>Aucun message</p>
      </div>
      <div v-else class="flex-1 overflow-y-auto">
        <div
          v-for="conv in conversations"
          :key="conv.id"
          class="p-3 rounded hover:bg-gray-100 cursor-pointer"
          :class="{ 'bg-gray-100': conv.id === selectedConversationId }"
          @click="selectConversation(conv.id)"
        >
          <p class="font-medium text-sm truncate">{{ conv.titleText }}</p>
          <p class="text-xs text-gray-500 truncate">Proposition : {{ conv.proposed_price ?? 'nulle' }}€ | Statut : {{ conv.status }}</p>
        </div>
      </div>
    </div>

    <div class="flex-1 flex flex-col justify-between bg-gray-50 p-6">
      <div class="space-y-3 max-w-2xl mx-auto">
        <div v-for="msg in negotiationHistory" :key="msg.id">
          <div
            class="max-w-[75%] p-3 rounded-lg shadow text-sm"
            :class="{
              'ml-auto bg-green-100 text-green-800': msg.user_id === user.id,
              'mr-auto bg-gray-100 text-gray-700': msg.user_id !== user.id
            }"
          >
            {{ msg.user_id === user.id ? 'Vous proposez' : (user.role === 'hotelier' ? 'Le client propose' : 'L’hôtelier propose') }} {{ msg.proposed_price }} €
            <p v-if="msg.status === 'accepted'" class="text-green-700 text-xs mt-1 font-semibold">Acceptée</p>
            <p v-if="msg.status === 'refused'" class="text-red-700 text-xs mt-1 font-semibold">Refusée</p>
            <p v-if="msg.status === 'countered'" class="text-yellow-700 text-xs mt-1 font-semibold">Contre-offre</p>
            <div v-if="remainingTime" class="text-center text-sm text-red-500">
            {{ remainingTime }}
          </div>
          </div>
        </div>
      </div>
      
      <div class="max-w-2xl mx-auto mt-6 space-y-4">
        <div v-if="lastNegotiation" class="text-center text-sm text-gray-500">
          Réduction : <span class="font-bold text-green-600">{{ discountPercent }}%</span>
        </div>

        <div class="flex items-center justify-center bg-white rounded-full px-4 py-2 shadow-sm border w-fit mx-auto space-x-2">
          <button @click="adjustPrice(-10)" class="text-gray-700 font-bold">-10</button>
          <button @click="adjustPrice(-1)" class="text-gray-700 font-bold">-1</button>
          <input v-model="price" type="number" class="text-center text-xl font-semibold w-24 outline-none border-0" />
          <button @click="adjustPrice(1)" class="text-gray-700 font-bold">+1</button>
          <button @click="adjustPrice(10)" class="text-gray-700 font-bold">+10</button>
        </div>

        <div class="w-full max-w-xs space-y-2 mx-auto">
          <button
            v-if="user.role === 'voyageur' && (lastNegotiation?.status === 'pending' || (!hasMadeOffer && lastNegotiation?.status === 'countered'))"
            @click="submitPrice"
            class="w-full bg-[#4c6764] text-white font-semibold py-2 rounded-full shadow-md hover:bg-[#3a504d]"
          >Soumettre</button>

          <button
            v-if="user.role === 'hotelier' && canAccept"
            @click="acceptPrice"
            class="w-full bg-[#1c443c] text-white font-semibold py-2 rounded-full hover:bg-[#13332d]"
          >Accepter</button>

          <button
            v-if="user.role === 'hotelier' && canAccept"
            @click="declinePrice"
            class="w-full bg-[#113029] text-white font-semibold py-2 rounded-full hover:bg-[#0d251f]"
          >Refuser</button>

          <button
            v-if="user.role === 'hotelier' && canAccept"
            @click="submitPrice"
            class="w-full bg-[#f59e0b] text-white font-semibold py-2 rounded-full hover:bg-[#d97706]"
          >↔ Proposer un nouveau prix</button>

          <button
            v-if="user.role === 'voyageur' && lastNegotiation?.status === 'accepted'"
            class="w-full bg-blue-600 text-white font-semibold py-2 rounded-full hover:bg-blue-700"
          >Passer à la réservation</button>

          <button
            v-if="user.role === 'voyageur' && lastNegotiation?.status === 'accepted'"
            @click="submitPrice"
            class="w-full bg-gray-600 text-white font-semibold py-2 rounded-full hover:bg-gray-700"
          >Proposer un nouveau prix</button>

          <button
            v-if="user.role === 'voyageur' && lastNegotiation?.status === 'countered' && !hasMadeOffer"
            @click="acceptPrice"
            class="w-full bg-green-600 text-white font-semibold py-2 rounded-full hover:bg-green-700"
          >Accepter la contre-offre</button>

          <button
            v-if="user.role === 'voyageur' && lastNegotiation?.status === 'countered' && !hasMadeOffer"
            @click="submitPrice"
            class="w-full bg-yellow-600 text-white font-semibold py-2 rounded-full hover:bg-yellow-700"
          >Faire une nouvelle proposition</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted, computed, watch } from 'vue'
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

const remainingTime = ref('')

function updateTimer() {
  if (!lastNegotiation.value?.expires_at) {
    remainingTime.value = null
    return
  }

  const expiration = new Date(lastNegotiation.value.expires_at.replace(' ', 'T'))
  const now = new Date()
  const diff = expiration - now

  if (diff <= 0) {
    remainingTime.value = 'Expirée'
  } else {
    const minutes = Math.floor((diff / 1000 / 60) % 60)
    const hours = Math.floor(diff / 1000 / 60 / 60)
    remainingTime.value = `${hours}h ${minutes}min restantes`
  }
}



onMounted(async () => {
  const userRes = await api.get('/api/user')
  user.value = userRes.data

  const roomId = route.query.room_id

  const negotiations = user.value.role === 'hotelier'
    ? await getHotelierNegotiations()
    : await getUserNegotiations()

  conversations.value = negotiations.map(n => ({
    id: n.id,
    room_id: n.room.id,
    titleText: `${n.room.name} - ${n.room.hotel.name}`,
    status: n.status,
    proposed_price: n.proposed_price
  }))

  if (roomId && user.value.role === 'voyageur') {
    const existing = conversations.value.find(c => c.room_id == roomId)
    if (!existing) {
      const response = await startNegotiation({ room_id: roomId, user_id: user.value.id })
      const room = await api.get(`/api/rooms/${roomId}`)
      conversations.value.push({
        id: response.data.id,
        room_id: roomId,
        titleText: `${room.data.name} - ${room.data.hotel.name}`,
        status: response.data.status,
        proposed_price: response.data.proposed_price
      })
      selectedConversationId.value = response.data.id
      router.replace({ path: '/negociation' })
    } else {
      selectedConversationId.value = existing.id
      router.replace({ path: '/negociation' })
    }
  }
  setInterval(updateTimer, 1000)
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
  updateTimer()
}

function adjustPrice(amount) {
  price.value = Math.max(1, price.value + amount)
}

async function submitPrice() {
  try {
    const selected = conversations.value.find(c => c.id === selectedConversationId.value)

    let res;

    if (negotiationHistory.value.length === 0) {
      res = await submitInitialOffer(selected.room_id, price.value)
    } else {
      res = await submitCounterOffer(lastNegotiation.value.id, price.value)
    }

    negotiationHistory.value.push(res.data.negotiation || res.data)
  } catch (err) {
    console.error('[SUBMIT ERROR]', err)
  }
}





async function acceptPrice() {
  const res = await acceptNegotiation(lastNegotiation.value.id)
  lastNegotiation.value.status = 'accepted'
}

async function declinePrice() {
  const res = await declineNegotiation(lastNegotiation.value.id)
  lastNegotiation.value.status = 'refused'
}
</script>
