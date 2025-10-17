<template>
  <div class="bg-gray-50 flex flex-col lg:flex-row">

    <div class="lg:w-1/2 p-8 md:p-16 lg:p-24 flex flex-col justify-center order-2 lg:order-1">
      
      <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight">
        <span class="text-gray-800">A WORLD OF</span>
        <br />
        <span class="text-yellow-500">COLOUR</span>
      </h1>

      <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-md">
        And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited. Sufficient particular
      </p>

      <button class="bg-gray-800 text-white font-semibold tracking-wide px-10 py-4 rounded-md shadow-2xl hover:bg-gray-700 transition duration-300 transform hover:scale-[1.02] self-start focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 cursor-pointer">
        Browse Full Collection
      </button>

    </div>

    <div class="lg:w-1/2 bg-yellow-500 flex items-center justify-center p-0 lg:p-0 order-1 lg:order-2 aspect-square lg:aspect-auto">
      
      <div class="w-full h-[850px] p-4 md:p-8 flex items-center justify-center">
        <img 
          src="../assets/images/banner.jpeg" 
          alt="A stylized product display"
          class="object-contain w-full h-full lg:max-h-full rounded-md"
        >
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: 'ColourHeroSection',
  // Component logic can be added here
  // For example, data properties, methods, etc.
};
</script>

<style scoped>
/* No additional CSS needed beyond Tailwind utility classes */
/* If you needed a custom font or complex gradient, you would add it here */
</style>