<template>
<div :class="props.phase_id === 6 ? 'bg-green-950 w-[300px] rounded-lg shadow-lg h-5/6 overflow-y-auto' :
'bg-sky-950 w-[300px] rounded-lg shadow-lg h-5/6 overflow-y-auto'">
    <div class="p-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg text-zinc-100 font-black mb-3">
                {{ kanban.phases[props.phase_id].name }}
                <span>({{ kanban.phases[props.phase_id].tasks_count }})</span>
            </h2>
            <div class="flex items-center justify-between">
                <PlusIcon
                    @click="createTask()"
                    class="mb-3 h-6 w-6 text-white hover:cursor-pointer"
                    aria-hidden="true" />
                <TrashIcon class="mb-3 ml-2 h-6 w-6 text-red-500 hover:cursor-pointer"
                    @click="deletePhaseAndPhaseTask(props.phase_id)" />
            </div>
        </div>
        <task-card v-if="kanban.phases[props.phase_id].tasks.length > 0" v-for="task in kanban.phases[props.phase_id].tasks" :task="task" />

        <!-- A card to create a new task -->
        <div class="w-full flex items-center justify-between bg-white text-gray-900 hover:cursor-pointer shadow-md rounded-lg p-3 relative"
            @click="createTask()">
            <span>Create a new task</span>
            <PlusIcon class="h-6 w-6" aria-hidden="true" />
        </div>
    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, TrashIcon } from '@heroicons/vue/20/solid'
import {ref} from "vue";
import { useToast } from "vue-toastification";

const kanban = useKanbanStore()
const errors = ref(null)
const success = ref(null)
const toast = useToast();

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})

const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}

const refreshTasks = async () => {
    try {
        const response = await axios.get('/api/tasks');
        const originalTasks = response.data;
        kanban.phases = originalTasks.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}

const deletePhaseAndPhaseTask = async (id) => {
    try {
        const response = await axios.delete(`/api/phases/${id}`);
        console.log({"response" : response})
        await refreshTasks();
        toast.success(response.data.message, {
           timeout: 2000
        });
    } catch (error) {
        console.error('There was an error deleting a phase the task!', error);
        toast.error( error.response.data.errors, {
            timeout: 2000
        });
    }
}

</script>
