<template>
    <section class="container mx-auto">
        <div class="flex w-full justify-center items-center h-full">
            <div class="flex flex-col py-10 px-16 w-[500px]">
                <h2 class="text-3xl font-bold mb-6 text-center">
                    Mot de passe oublié ?
                </h2>
                <FormKit
                    type="form"
                    submit-label="Envoyer"
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
                        type="email"
                        name="email"
                        validation="required"
                        label="E-mail"
                        :classes="{
                            input: 'mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                        }"
                    />
                </FormKit>
            </div>
        </div>
    </section>
</template>

<script setup>
import { FormKit } from "@formkit/vue";
import { useToast } from "vue-toastification";
import { useUserStore } from "../store/user";
const userStore = useUserStore();
const toast = useToast();

const submit = async (values) => {
    const response = await userStore.forgotPassword(values);
    if (response.ok) {
        toast.success("Un email vous a été envoyé");
    } else {
        const responseJson = await response.json();
        toast.error(responseJson.detail);
    }
};
</script>
