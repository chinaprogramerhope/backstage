import request from '@/utils/request'

/**
 * 游戏分组 - 获取游戏分组
 */
export function groupGet() {
  const data = {
    cmd: 106,
    param: {

    }
  }

  var ret = request({
    url: 'http://192.168.1.127:8102',
    method: 'post',
    data
  })

  // test todo 这里为什么是空对象, 而gameGroup.vue中调用方法获取的不是空
  console.log('ret1 = ' + JSON.stringify(ret))
  return ret
}

/**
 * 游戏分组 - 获取分组内的游戏
 * @param {*} gameName
 * @param {*} gameType
 * @param {*} gameStatus
 */
export function groupGetGames(groupId) {
  const data = {
    cmd: 107,
    param: {
      groupId: groupId
    }
  }

  var ret = request({
    url: 'http://192.168.1.127:8102',
    method: 'post',
    data
  })

  return ret
}

/**
 * 游戏列表 - 获取游戏列表
 * @param {*} gameName
 * @param {*} gameType
 * @param {*} gameStatus
 */
export function listGet(gameName, gameType, gameStatus) {
  const data = {
    cmd: 101,
    param: {
      gameName: gameName,
      gameType: gameType,
      gameStatus: gameStatus
    }
  }

  var ret = request({
    url: 'http://192.168.1.127:8102',
    method: 'post',
    data
  })

  return ret
}
