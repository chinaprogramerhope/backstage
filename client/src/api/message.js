import request from '@/utils/request'

/**
 * 游戏分组 - 获取游戏分组
 * @param {*} type
 * @param {*} timeBegin
 */
export function announceListGet(type, timeBegin) {
  const data = {
    cmd: 201,
    param: {
      type: type,
      dateRange: timeBegin
    }
  }

  var ret = request({
    url: 'http://47.244.177.7:8091/index.php',
    method: 'post',
    data
  })

  // test todo 这里为什么是空对象, 而gameGroup.vue中调用方法获取的不是空
  console.log('ret1 = ' + JSON.stringify(ret))
  return ret
}

/**
 * 公告列表 - 删除
 * @param {*} announceId
 */
export function announceListDel(announceId) {
  const data = {
    cmd: 204,
    param: {
      announceId: announceId
    }
  }

  var ret = request({
    url: 'http://47.244.177.7:8091/index.php',
    method: 'post',
    data
  })

  // test todo 这里为什么是空对象, 而gameGroup.vue中调用方法获取的不是空
  console.log('ret1 = ' + JSON.stringify(ret))
  return ret
}
