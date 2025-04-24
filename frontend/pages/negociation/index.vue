<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-72 border-r bg-white p-4 flex flex-col">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Messages</h2>
        <button class="text-sm text-gray-600 hover:text-black">⚙️</button>
      </div>

      <!-- Filtres -->
      <div class="mb-4 flex gap-2">
        <button class="text-sm font-medium px-3 py-1 border rounded bg-black text-white">Tous</button>
        <button class="text-sm font-medium px-3 py-1 border rounded text-black">Non lus</button>
      </div>

      <!-- Liste -->
      <div v-if="conversations.length === 0" class="flex-1 flex items-center justify-center text-gray-500">
        <div>
          <div class="text-4xl mb-2">💬</div>
          <p>Aucun message</p>
          <p class="text-sm text-gray-400">Ils s'afficheront ici dès qu'une négociation démarre.</p>
        </div>
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
          <p class="text-xs text-gray-500 truncate">{{ conv.lastMessageText }}</p>
        </div>
      </div>
    </div>

    <!-- Détail -->
    <div class="flex-1 flex flex-col justify-center items-center bg-gray-50 text-gray-400">
      <div v-if="!selectedConversationId" class="text-center">
        <p class="text-xl font-semibold">Aucune conversation sélectionnée</p>
        <p class="text-sm text-gray-500">Cliquez sur une négo pour l’afficher ici</p>
      </div>

      <div v-else class="p-6 w-full space-y-4 max-w-2xl">
        <!-- Historique -->
        <div v-for="history in negotiationHistory" :key="history.id" class="bg-white border p-3 rounded shadow-sm">
          <p class="text-sm font-medium text-gray-800">
            {{ history.created_at }} — {{ history.status.toUpperCase() }}
          </p>
          <p class="text-sm text-gray-600">
            Prix proposé : <strong>{{ history.proposed_price }}€</strong> (Prix initial : {{ history.initial_price }}€)
          </p>
        </div>

        <!-- Interface de négociation -->
        <div class="text-center mt-6 flex flex-col items-center space-y-4">
          <div class="text-sm text-gray-500">Réduction : <span class="text-green-600 font-semibold">{{ discountPercent }}%</span></div>

          <div class="flex items-center justify-center bg-white rounded-full px-4 py-2 shadow-sm border w-fit space-x-2">
            <button @click="adjustPrice(-10)" class="text-gray-700 font-bold">-10</button>
            <button @click="adjustPrice(-1)" class="text-gray-700 font-bold">-1</button>
            <input v-model="price" type="number" class="text-center text-xl font-semibold w-24 outline-none border-0" />
            <button @click="adjustPrice(1)" class="text-gray-700 font-bold">+1</button>
            <button @click="adjustPrice(10)" class="text-gray-700 font-bold">+10</button>
          </div>

          <div class="w-full max-w-xs space-y-2">
            <button
              v-if="lastNegotiation?.status === 'pending' || (!hasMadeOffer && lastNegotiation?.status === 'countered')"
              @click="submitPrice"
              class="w-full bg-[#4c6764] text-white font-semibold py-2 rounded-full shadow-md hover:bg-[#3a504d] transition"
            >Soumettre</button>

            <button
              v-if="canAccept"
              @click="acceptPrice"
              class="w-full bg-[#1c443c] text-white font-semibold py-2 rounded-full hover:bg-[#13332d] transition"
            >Accepter</button>

            <button
              v-if="canAccept"
              @click="declinePrice"
              class="w-full bg-[#113029] text-white font-semibold py-2 rounded-full hover:bg-[#0d251f] transition"
            >Refuser</button>
          </div>
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
  startNegotiation,
  getNegotiationHistoryByRoom,
  submitCounterOffer,
  acceptNegotiation,
  declineNegotiation
} from '~/lib/negociation'
import { api } from '~/lib/api'

const conversations = ref([])
const selectedConversationId = ref(null)
const negotiationHistory = ref([])
const route = useRoute()
const router = useRouter()

const price = ref(100)
const initialPrice = ref(100)
const lastNegotiation = computed(() => negotiationHistory.value.at(-1) || null)
const hasMadeOffer = computed(() => lastNegotiation.value?.user_id === 1)
const canAccept = computed(() => lastNegotiation.value?.user_id !== 1)

const discountPercent = computed(() => {
  if (!initialPrice.value || !price.value) return 0
  return Math.round((1 - price.value / initialPrice.value) * 100)
})

onMounted(async () => {
  try {
    const userRes = await api.get('/api/user')
    const user = userRes.data
    const roomId = route.query.room_id

    const negotiations = await getUserNegotiations()

    conversations.value = negotiations.map(n => ({
      id: n.id,
      room_id: n.room.id,
      titleText: `${n.room.name} - ${n.room.hotel.name}`,
      lastMessageText: `Proposition : ${n.proposed_price}€ | Statut : ${n.status}`
    }))

    if (roomId) {
      const existing = conversations.value.find(c => c.room_id == roomId)
      if (!existing) {
        const response = await startNegotiation({ room_id: roomId, user_id: user.id, proposed_price: 100 })
        const newNegotiation = response.data
        const room = await api.get(`/api/rooms/${roomId}`)
        conversations.value.push({
          id: newNegotiation.id,
          room_id: roomId,
          titleText: `${room.data.name} - ${room.data.hotel.name}`,
          lastMessageText: `Proposition : ${newNegotiation.proposed_price}€ | Statut : ${newNegotiation.status}`
        })
        selectedConversationId.value = newNegotiation.id
        router.replace({ path: '/negociation' })
      } else {
        selectedConversationId.value = existing.id
        router.replace({ path: '/negociation' })
      }
    }
  } catch (err) {
    console.error('[LOAD NEGOTIATIONS ERROR]', err)
  }
})

async function selectConversation(id) {
  selectedConversationId.value = id
  const selected = conversations.value.find(c => c.id === id)
  if (selected) {
    try {
      const history = await getNegotiationHistoryByRoom(selected.room_id)
      negotiationHistory.value = history
      if (history.length > 0) {
        initialPrice.value = parseFloat(history[0].initial_price)
        price.value = parseFloat(history.at(-1).proposed_price)
      }
    } catch (err) {
      console.error('[LOAD NEGOTIATION HISTORY ERROR]', err)
      negotiationHistory.value = []
    }
  }
}

function adjustPrice(amount) {
  price.value = Math.max(1, price.value + amount)
}

async function submitPrice() {
  try {
    const selected = conversations.value.find(c => c.id === selectedConversationId.value)
    const res = await submitCounterOffer(selected.room_id, price.value)
    negotiationHistory.value.push(res.data)
  } catch (err) {
    console.error('[SUBMIT PRICE ERROR]', err)
  }
}

async function acceptPrice() {
  try {
    const res = await acceptNegotiation(lastNegotiation.value.id)
    lastNegotiation.value.status = 'accepted'
  } catch (err) {
    console.error('[ACCEPT ERROR]', err)
  }
}

async function declinePrice() {
  try {
    const res = await declineNegotiation(lastNegotiation.value.id)
    lastNegotiation.value.status = 'refused'
  } catch (err) {
    console.error('[DECLINE ERROR]', err)
  }
}
</script>