module.exports = {
    company: "ThemeXpert",
    copyright: "&copy; 2010-2016 ThemeXpert Inc. All Rights Reserved.",
    getLang() {
        return {
            nav: {
                dashboard: "ড্যাশবোর্ড",
                releases: "মুক্তিপ্রাপ্ত",
                products: "পণ্য",
                settings: "সেটিংস",
                tokens: "Tokens",
                reports: "প্রতিবেদন"
            },
            auth: {
                form: {
                    login: {
                        title: "প্রবেশ করুন",
                        or: "অথবা",
                        email: {
                            label: "ইমেইল",
                            placeholder: "আপনার ইমেইল"
                        },
                        password: {
                            label: "পাসওয়ার্ড",
                            placeholder: "Password"
                        },
                        remember_me: "এই কম্পিউটারে আমাকে মনে রাখুন",
                        forgot_password: "আপনি কি পাসওয়ার্ড ভুলে গেছেন?",
                        btn_login: "প্রবেশ করুন",
                        dont_have_an_account: "অ্যাকাউন্ট নেই?",
                        url_sign_up: "নিবন্ধন করুন"
                    },
                    register: {
                        title: "নিবন্ধন করুন",
                        name: {
                            label: "নাম",
                            placeholder: "আপনার নাম"
                        },
                        email: {
                            label: "ইমেইল",
                            placeholder: "আপনার ইমেইল"
                        },
                        password: {
                            label: "পাসওয়ার্ড",
                            placeholder: "Password"
                        },
                        password_confirmation: {
                            label: "পাসওয়ার্ড নিশ্চিত করুন",
                            placeholder: "Password"
                        },
                        btn_sign_up: "নিবন্ধন করুন",
                    }
                },
                nav: {
                    login: "প্রবেশ করুন",
                    register: "নিবন্ধন করুন",
                    logout: "প্রস্থান"
                }
            },
            title_text: {
                features: this.company + " এর জন্য বৈশিষ্ট্য অনুরোধ",
                product_list: this.company + " এর পণ্য তালিকা",
                reports: "বৈশিষ্ট্য প্রতিবেদন"
            },
            modal: {
                feature_request: {
                    title: this.company + " এর জন্য বৈশিষ্ট্য অনুরোধ",
                    feature: {
                        label: "Suggest a feature",
                        placeholder: "What do you have in mind ?"
                    },
                    details: {
                        label: "Add details (if you need to)",
                        placeholder: "Please keep this as details as possible ..."
                    },
                    btn_suggest: "Tell " +this.company+" I want this"
                },
                edit_feature_request: {
                    title: "Update feature Request",
                    feature: {
                        label: "Feature",
                        placeholder: "What do you have in mind ?"
                    },
                    details: {
                        label: "Add details (if you need to)",
                        placeholder: "Please keep this as details as possible ..."
                    },
                    btn_suggest: "Update"
                },
                status_update: {
                    title: "Update Status",
                    subject: {
                        label: "Subject",
                        placeholder: "Subject"
                    },
                    message: {
                        label: "Status Note",
                        placeholder: "Add some note"
                    },
                    btn_status: "Update"
                },
                effort_update: {
                    title: "Update Effort",
                    effort: {
                        label: "Effort"
                    },
                    btn_effort: "Update"
                },
                comment: {
                    title: "Add a comment",
                    comment: {
                        label: "Add Comment",
                        placeholder: "You need to add some text to your comment."
                    },
                    btn_comment: "Save comment"
                },
                confirm: {
                    title: "",
                    btn_confirm: "Confirm",
                    btn_cancel: "Cancel",
                    messages: {
                        delete_product: "Are you sure you want to delete this product?",
                        delete_feature: "Are you sure you want to delete this feature?"
                    }
                },
                new_product: {
                    title: "Add new product",
                    product: {
                        label: "Product Name",
                        placeholder: "Product Name"
                    },
                    description: {
                        label: "Add Details",
                        placeholder: "Please keep this as details as possible ..."
                    },
                    btn_product: "Save Product"
                },
                edit_product: {
                    title: "Update Product",
                    product: {
                        label: "Product Name",
                        placeholder: "Product Name"
                    },
                    description: {
                        label: "Add Details",
                        placeholder: "Please keep this as details as possible ..."
                    },
                    btn_product: "Update Product"
                }
            },
            search_box: "Search Feature",
            button: {
                suggest_feature: "Suggest a feature for " + this.company,
                add_product: "Add new Product",
                update_effort: "Update Effort",
                update_status: "Status Update",
                interested: "I Want This",
                not_interested: "Not Interested",
                close: "Close"

            },
            status: {
                '': "সব",
                pending: "মুলতুবি",
                wip: "চলছে",
                released: "মুক্তিপ্রাপ্ত",
                declined: "পতিত"
            },
            tooltip: {
                status: {
                    pending: "মুলতুবি",
                    wip: "চলছে",
                    released: "মুক্তিপ্রাপ্ত",
                    declined: "পতিত"
                }
            },
            no_result_message: {
                feature_requests: "No feature request found.",
                products: "No product found.",
                comments: "No comment on this feature",
                search: "No result found for this query"
            },
            panel_title: {
                action: "Action",
                feedback: "Feature Feedback",
                status_update: "Status Update",
                status: "Status",
                discussion: "Discussion",
                prepared_reports: "Prepared Reports",
                feature_filter: "Feature Filter",
                feature_tags: "Feature Tags"
            },
            panel_text: {
                action: {
                    interested: "people wants this",
                    not_interested: "not interested"
                },
                filter: {
                    any: "Any",
                    private: "Private",
                    public: "Public"
                }
            },
            table: {
                reports: {
                    value: "Value",
                    feature: "Feature",
                    status: "Status"
                }
            },
            copyright: this.copyright
        };
    }
};