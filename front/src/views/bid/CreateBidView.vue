<template>
    <div class="flex w-full justify-center items-center h-full">
        <div class="flex flex-col py-10 px-16 w-[500px]">
            <h2 class="text-3xl font-bold mb-6 text-center">Create a bid</h2>
            <FormKit
                type="form"
                submit-label="Créer une enchère"
                :classes="{
                    form: 'space-y-6',
                }"
                :submit-attrs="{
                    outerClass: 'pt-4',
                    inputClass:
                        'w-full rounded-md bg-indigo-600 py-2.5 px-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600',
                }"
                @submit="submit"
            >
                <FormKit
                    type="text"
                    name="title"
                    validation="required"
                    label="Titre"
                    :classes="{
                        input: 'mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                    }"
                />
                <FormKit
                    type="datetime-local"
                    name="startDate"
                    validation="required"
                    label="Date de début"
                    :classes="{
                        input: 'mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                    }"
                />
                <FormKit
                    type="datetime-local"
                    name="endDate"
                    validation="required"
                    label="Date de fin"
                    :classes="{
                        input: 'mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                    }"
                />
                <FormKit
                    type="number"
                    min="0.01"
                    step="0.01"
                    name="startPrice"
                    validation="required"
                    label="Prix d'entrée"
                    :classes="{
                        input: 'mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                    }"
                />
            </FormKit>
        </div>
    </div>
</template>

<script setup>
import { addNewBid } from "@/services/bid";
import { useRouter } from "vue-router";
import { FormKit } from "@formkit/vue";
import { useToast } from "vue-toastification";

const router = useRouter();
//const userStore = useUserStore();

const submit = async (values) => {
    const toast = useToast();
    const response = await addNewBid(values);

    if (response.ok) {
        toast.success("Enchère créée avec succès !");
        await router.push("/bids");
    } else {
        toast.error(
            "Une erreur est survenue veuillez réessayer ultérieurement"
        );
    }
};
</script>
