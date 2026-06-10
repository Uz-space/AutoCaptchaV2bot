import asyncio
import logging
from aiogram import Bot, Dispatcher, F
from aiogram.types import Message, CallbackQuery, InlineKeyboardMarkup, InlineKeyboardButton
from aiogram.filters import CommandStart

logging.basicConfig(level=logging.INFO)

BOT_TOKEN = "YOUR_BOT_TOKEN_HERE"

# ─── Kran konfiguratsiyasi ───────────────────────────────────────────────────
# active=True  → akkount ulangan: ✅ ko'rinadi, claims va multiplier chiqadi
# active=False → akkount ulanmagan: ⚠️ ko'rinadi, hech narsa chiqmaydi
CRANES = [
    {"name": "PolPick",  "emoji": "🪙",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "BnbPick",  "emoji": "🟡",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "DogePick", "emoji": "🐕",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "SolPick",  "emoji": "☀️",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "SuiPick",  "emoji": "💧",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "LitePick", "emoji": "🌕",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "TronPick", "emoji": "🔴",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "UsdPick",  "emoji": "💵",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "TonPick",  "emoji": "💎",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "BchPick",  "emoji": "🟤",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
]

# ─── Global holat ────────────────────────────────────────────────────────────
# api_connected=True bo'lganda ✅, False bo'lganda ❌ ko'rinadi
# accounts=-1 → cheksiz (∞), musbat son → aniq son
# total_claims faqat muvaffaqiyatli claim bo'lganda oshadi
API_STATE = {
    "connected": False,
    "domain": "sctg.xyz",
    "plan": "Trial",
    "accounts": 0,
    "total_claims": 0,
}

# Oxirgi muvaffaqiyatli claim logi
# log_text bo'sh bo'lsa "Hali claim amalga oshirilmagan..." chiqadi
LIVE_LOG = {
    "crane_emoji": "",
    "crane_name": "",
    "log_text": "",
}


# ─── Matn generatsiyasi ──────────────────────────────────────────────────────
def build_message_text() -> str:
    lines = []
    for c in CRANES:
        if c["active"]:
            mult = f" | 🟢 {c['multiplier']}" if c["multiplier"] else ""
            line = (
                f"{c['emoji']} {c['name']} ✅ [∞]"
                f"{mult} ({c['claims']}/{c['max_claims']})"
            )
        else:
            line = f"{c['emoji']} {c['name']} ⚠️ [∞] | ▪️ (0/{c['max_claims']})"
        lines.append(line)

    text = "\n".join(lines)
    text += "\n\n"

    # API holati — ulanganda ✅, ulanmaganda ❌
    api_icon = "✅" if API_STATE["connected"] else "❌"
    text += f"🔑 API: {api_icon} ({API_STATE['domain']})\n"

    # Plan/accounts/claims — faqat API ulangan va akkount bo'lganda
    if API_STATE["connected"] and API_STATE["accounts"] != 0:
        acc_str    = "∞" if API_STATE["accounts"] == -1 else str(API_STATE["accounts"])
        claims_str = str(API_STATE["total_claims"]) if API_STATE["total_claims"] > 0 else "0"
        text += f"🆓 {API_STATE['plan']} | {acc_str} accounts | {claims_str} claims\n"

    text += "\n📡 LIVE LOG\n"
    text += "─" * 32 + "\n"

    # Live log — claim bo'lmasa placeholder chiqadi
    if LIVE_LOG["log_text"]:
        text += f"{LIVE_LOG['crane_emoji']} {LIVE_LOG['crane_name']}\n"
        text += LIVE_LOG["log_text"]
    else:
        text += "⏳ Hali claim amalga oshirilmagan..."

    return text


# ─── Inline klaviatura ───────────────────────────────────────────────────────
def build_keyboard() -> InlineKeyboardMarkup:
    buttons = []

    # Kran tugmalari — 2 tadan qator
    row = []
    for c in CRANES:
        icon = "🟢" if c["active"] else "⚠️"
        btn = InlineKeyboardButton(
            text=f"{icon} {c['name']}",
            callback_data=f"crane_{c['name']}"
        )
        row.append(btn)
        if len(row) == 2:
            buttons.append(row)
            row = []
    if row:
        buttons.append(row)

    # Proxies — to'liq kenglik
    buttons.append([InlineKeyboardButton(text="🌐 Proxies", callback_data="proxies")])

    # Tizim tugmalari — har biri alohida qatorda
    buttons.append([InlineKeyboardButton(text="📊 Stats & Balance", callback_data="stats")])
    buttons.append([InlineKeyboardButton(text="💳 Subscription",    callback_data="subscription")])
    buttons.append([InlineKeyboardButton(text="🎁 Invite Friend",   callback_data="invite")])

    # Settings + Refresh — yonma-yon
    buttons.append([
        InlineKeyboardButton(text="⚙️ Settings", callback_data="settings"),
        InlineKeyboardButton(text="🔄",           callback_data="refresh"),
    ])

    return InlineKeyboardMarkup(inline_keyboard=buttons)


# ─── Bot va Dispatcher ───────────────────────────────────────────────────────
bot = Bot(token=BOT_TOKEN)
dp  = Dispatcher()


# ─── /start handleri ─────────────────────────────────────────────────────────
@dp.message(CommandStart())
async def cmd_start(message: Message):
    await message.answer(
        text=build_message_text(),
        reply_markup=build_keyboard(),
        parse_mode=None
    )


# ─── Refresh callback ────────────────────────────────────────────────────────
@dp.callback_query(F.data == "refresh")
async def cb_refresh(call: CallbackQuery):
    await call.message.edit_text(
        text=build_message_text(),
        reply_markup=build_keyboard(),
        parse_mode=None
    )
    await call.answer("♻️ Yangilandi!")


# ─── Kran callback ───────────────────────────────────────────────────────────
@dp.callback_query(F.data.startswith("crane_"))
async def cb_crane(call: CallbackQuery):
    crane_name = call.data.replace("crane_", "")
    await call.answer(f"⚙️ {crane_name} sozlamalari", show_alert=False)


# ─── Proxies callback ────────────────────────────────────────────────────────
@dp.callback_query(F.data == "proxies")
async def cb_proxies(call: CallbackQuery):
    await call.answer("🌐 Proxies bo'limi", show_alert=False)


# ─── Stats callback ──────────────────────────────────────────────────────────
@dp.callback_query(F.data == "stats")
async def cb_stats(call: CallbackQuery):
    await call.answer("📊 Stats & Balance", show_alert=False)


# ─── Subscription callback ───────────────────────────────────────────────────
@dp.callback_query(F.data == "subscription")
async def cb_subscription(call: CallbackQuery):
    await call.answer("💳 Subscription", show_alert=False)


# ─── Invite callback ─────────────────────────────────────────────────────────
@dp.callback_query(F.data == "invite")
async def cb_invite(call: CallbackQuery):
    await call.answer("🎁 Invite Friend", show_alert=False)


# ─── Settings callback ───────────────────────────────────────────────────────
@dp.callback_query(F.data == "settings")
async def cb_settings(call: CallbackQuery):
    await call.answer("⚙️ Settings", show_alert=False)


# ─── Main ────────────────────────────────────────────────────────────────────
async def main():
    await dp.start_polling(bot)

if __name__ == "__main__":
    asyncio.run(main())
