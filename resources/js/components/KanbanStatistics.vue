<template class="d-block">
      <div class="flex flex-row">
          <div class="w-1/2 custom-height col m-4 bg-white rounded-lg p-8 shadow-sm text-center">
              <div class="border-b-2 pb-2 text-xl font-semibold">Users Card</div>
              <div class="h-screen pt-4 custom-statistics-height flex justify-center">
                  <canvas id="user-statistics"></canvas>
              </div>
          </div>
          <div class="w-1/2 custom-height col m-4 bg-white rounded-lg p-8 shadow-sm text-center">
               <div class="border-b-2 pb-2 text-xl font-semibold">Completed Task</div>
               <div class="h-screen pt-4 custom-statistics-height flex justify-center">
                   <canvas id="completed-card-statistics"></canvas>
               </div>
           </div>
      </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Chart from 'chart.js/auto';
import { useKanbanStore } from '../stores/kanban'

const kanban = useKanbanStore()

let pos = { top: 0, left: 0, x: 0, y: 0 };
let ele;

const getUsersStatistics = async () => {
    try {
        const response = await axios.get('/api/users-statistics');
        return await response.data;
    } catch (error) {
        console.error('There was an error fetching the users statistics!', error);
    }
}

const getCompletedTaskStatistics = async () => {
    try {
        const response = await axios.get('/api/completed-card-statistics');
        return await response.data;
    } catch (error) {
        console.error('There was an error fetching the completed card statistics!', error);
    }
}

onMounted(async () => {

    const usersStatisticsData = await getUsersStatistics();
    const completedTaskStatistics = await getCompletedTaskStatistics();

    const ctx = document.getElementById('user-statistics').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: usersStatisticsData.data.labels,
            datasets: [
                usersStatisticsData.data.datasets
            ]
        },
        options: {}
    });

    const ctx1 = document.getElementById('completed-card-statistics').getContext('2d');
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: completedTaskStatistics.data.labels,
            datasets: [
                completedTaskStatistics.data.datasets
            ]
        },
        options: {}
    });


})
</script>

<style scoped>
.custom-height{
    height: 80vh;
}
.custom-statistics-height{
    height: 70vh;
}
</style>
