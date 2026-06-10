import asyncio
import logging
from aiogram import Bot, Dispatcher, F
from aiogram.types import Message, CallbackQuery, InlineKeyboardMarkup, InlineKeyboardButton
from aiogram.filters import CommandStart

logging.basicConfig(level=logging.INFO)

BOT_TOKEN = "8985212757:AAEFicAmp1IHWLanCUjsoLGD9yOhpR64JfE"

# ─── Kran konfiguratsiyasi ───────────────────────────────────────────────────
# TronPick, LitePick, DogePick — birinchi 3 ta (1-2 pozitsiya)
# Qolganlar ketma-ket
CRANES = [
    {"name": "TronPick", "emoji": "🔴",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "LitePick", "emoji": "🌕",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "DogePick", "emoji": "🐕",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "PolPick",  "emoji": "🪙",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "BnbPick",  "emoji": "🟡",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "SolPick",  "emoji": "☀️",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "SuiPick",  "emoji": "💧",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "UsdPick",  "emoji": "💵",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "TonPick",  "emoji": "💎",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
    {"name": "BchPick",  "emoji": "🟤",  "active": False, "multiplier": None, "claims": 0, "max_claims": "∞"},
]

# ─── Global holat ────────────────────────────────────────────────────────────
API_STATE = {
    "connected": False,
    "domain": "sctg.xyz",
    "plan": "Trial",
    "accounts": 0,
    "total_claims": 0,
}

LIVE_LOG = {
    "crane_emoji": "",
    "crane_name": "",
    "log_text": "",
}


# ─── Matn generatsiyasi ──────────────────────────────────────────────────────
def build_message_text() -> str:
    lines = []
    for c in CRANES:
        # Nom KATTA HARF
        name_upper = c["name"].upper()
        if c["active"]:
            mult = f" | 🟢 {c['multiplier']}" if c["multiplier"] else ""
            line = (
                f"{c['emoji']} {name_upper} ✅ [∞]"
                f"{mult} ({c['claims']}/{c['max_claims']})"
            )
        else:
            line = f"{c['emoji']} {name_upper} ⚠️ [∞] | ▪️ (0/{c['max_claims']})"
        lines.append(line)

    text = "\n".join(lines)
    text += "\n\n"

    api_icon = "✅" if API_STATE["connected"] else "❌"
    text += f"🔑 API: {api_icon} ({API_STATE['domain']})\n"

    if API_STATE["connected"] and API_STATE["accounts"] != 0:
        acc_str    = "∞" if API_STATE["accounts"] == -1 else str(API_STATE["accounts"])
        claims_str = str(API_STATE["total_claims"]) if API_STATE["total_claims"] > 0 else "0"
        text += f"🆓 {API_STATE['plan']} | {acc_str} accounts | {claims_str} claims\n"

    text += "\n📡 LIVE LOG\n"
    text += "─" * 32 + "\n"

    if LIVE_LOG["log_text"]:
        text += f"{LIVE_LOG['crane_emoji']} {LIVE_LOG['crane_name'].upper()}\n"
        text += LIVE_LOG["log_text"]
    else:
        text += "⏳ Hali claim amalga oshirilmagan..."

    return text


# ─── Inline klaviatura ───────────────────────────────────────────────────────
def build_keyboard() -> InlineKeyboardMarkup:
    buttons = []

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

    buttons.append([InlineKeyboardButton(text="🌐 Proxies", callback_data="proxies")])
    buttons.append([InlineKeyboardButton(text="📊 Stats & Balance", callback_data="stats")])
    buttons.append([InlineKeyboardButton(text="💳 Subscription",    callback_data="subscription")])
    buttons.append([InlineKeyboardButton(text="🎁 Invite Friend",   callback_data="invite")])
    buttons.append([
        InlineKeyboardButton(text="⚙️ Settings", callback_data="settings"),
        InlineKeyboardButton(text="🔄",           callback_data="refresh"),
    ])

    return InlineKeyboardMarkup(inline_keyboard=buttons)


# ─── Bot va Dispatcher ───────────────────────────────────────────────────────
bot = Bot(token=BOT_TOKEN)
dp  = Dispatcher()

# Bot username (startup da on_startup() orqali aniqlanadi)
BOT_USERNAME = ""


@dp.message(CommandStart())
async def cmd_start(message: Message):
    await message.answer(
        text=build_message_text(),
        reply_markup=build_keyboard(),
        parse_mode=None
    )


@dp.callback_query(F.data == "refresh")
async def cb_refresh(call: CallbackQuery):
    await call.message.delete()
    await call.message.answer(
        text=build_message_text(),
        reply_markup=build_keyboard(),
        parse_mode=None
    )
    await call.answer("♻️ Yangilandi!")


@dp.callback_query(F.data.startswith("crane_"))
async def cb_crane(call: CallbackQuery):
    crane_name = call.data.replace("crane_", "")
    await call.answer(f"⚙️ {crane_name} sozlamalari", show_alert=False)


@dp.callback_query(F.data == "proxies")
async def cb_proxies(call: CallbackQuery):
    await call.answer("🌐 Proxies bo'limi", show_alert=False)


@dp.callback_query(F.data == "stats")
async def cb_stats(call: CallbackQuery):
    await call.answer("📊 Stats & Balance", show_alert=False)


@dp.callback_query(F.data == "subscription")
async def cb_subscription(call: CallbackQuery):
    await call.answer("💳 Subscription", show_alert=False)


@dp.callback_query(F.data == "invite")
async def cb_invite(call: CallbackQuery):
    user = call.from_user
    ref_code = f"ref_{user.id}"
    ref_link = f"https://t.me/{BOT_USERNAME}?start={ref_code}"

    text = (
        "🎁🎁 <b>Referral System</b>\n"
        "━━━━━━━━━━━━━━━━━━━━━━━━\n\n"
        "🔗 <b>Your referral link:</b>\n"
        f"<code>{ref_link}</code>\n\n"
        "📢 <b>Share this link with your friends!</b>\n"
        "├ You get: <b>+16 claims</b>\n"
        "└ Your friend gets: <b>+8 claims</b>\n\n"

        "👥 <b>Friends joined:</b> 0\n"
        "📊 <b>Bonus claims earned:</b> 0"
    )

    keyboard = InlineKeyboardMarkup(inline_keyboard=[
        [InlineKeyboardButton(text="📨 Share with Friend", url=f"https://t.me/share/url?url={ref_link}&text=Menga+qo%27shil%21")],
        [InlineKeyboardButton(text="◀️ Back", callback_data="back_main")],
    ])

    await call.message.delete()
    await call.message.answer(text=text, reply_markup=keyboard, parse_mode="HTML")
    await call.answer()


@dp.callback_query(F.data == "settings")
async def cb_settings(call: CallbackQuery):
    await call.answer("⚙️ Settings", show_alert=False)


@dp.callback_query(F.data == "back_main")
async def cb_back_main(call: CallbackQuery):
    await call.message.delete()
    await call.message.answer(
        text=build_message_text(),
        reply_markup=build_keyboard(),
        parse_mode=None
    )
    await call.answer()


async def on_startup():
    global BOT_USERNAME
    me = await bot.get_me()
    BOT_USERNAME = me.username


async def main():
    await on_startup()
    await dp.start_polling(bot)

if __name__ == "__main__":
    asyncio.run(main())
